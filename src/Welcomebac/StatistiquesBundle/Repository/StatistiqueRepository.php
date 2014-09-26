<?php

namespace Welcomebac\StatistiquesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StatistiqueRepository extends EntityRepository {

    /**
     * Permet de recuperer les associations entre les ressources en prenant en compte
     * les entrées ajoutées pour limiter la lourdeur de la requete MySQL
     * @param type $objet
     * @param type $limite
     * @return type
     */
    public function getAssociations($objet, $limite = 5) {
        if (get_class($objet) == 'Welcomebac\EntitesBundle\Entity\Annale') {
            $type = "annale";
            $campagne = 'Acces pdf|Annale';
            $compteur_annale = 1; 
            $compteur_fiche = 0; 
        } else {
            $type = "fiche";
            $campagne = 'Acces pdf|Fiche';
            $compteur_fiche = 1; 
            $compteur_annale = 0; 
        }
        
        //recuperation des stats archivés
        $query = $this->getEntityManager()
                ->createQueryBuilder();
        
        $query  = $query
                ->select('s.description, s.campagne, s.date')
                ->from('Welcomebac\StatistiquesBundle\Entity\Statistique', 's')
                ->where('
                    (
                        ( 
                            s.campagne =:campagne_annale_fiche 
                            OR s.campagne =:campagne_annale_annale
                        ) AND 1=:compteur_annale
                    ) OR (
                        ( 
                            s.campagne =:campagne_fiche_annale 
                            OR s.campagne =:campagne_fiche_fiche
                        ) AND 1=:compteur_fiche
                    )')
                ->andWhere($query->expr()->like('s.description', '?1'))
                ->setParameter('campagne_annale_fiche', 'Associations|Annale-Fiche')
                ->setParameter('campagne_annale_annale', 'Associations|Annale-Annale')
                ->setParameter('campagne_fiche_annale', 'Associations|Fiche-Annale')
                ->setParameter('campagne_fiche_fiche', 'Associations|Fiche-Fiche')
                ->setParameter('compteur_fiche', $compteur_fiche)
                ->setParameter('compteur_annale', $compteur_annale)
                ->setParameter('1', $objet->getId().'-%')
                ->orderBy('s.date', 'DESC')
                ->groupBy('s.id_element')
                ->getQuery();
        
        $compteurs = $query->getResult();
        
        $associations = array();
        if(count($compteurs)){
            foreach($compteurs as $cle => $el){
                preg_match('/^([0-9]*)-([0-9]*)-([0-9]*)$/', $el['description'], $matches);
                $associations[] = array(
                        'id_element'    => $matches[2], 
                        'nb'            => $matches[3], 
                        'type'          => (preg_match('/Fiche$/', $el['campagne']))?'fiche':'annale',
                        'date'          => $el['date']
                    );
            }
        }
        
        //recuperation des stats non archivés
        $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('ass.id_element, ass.campagne, COUNT(DISTINCT ass.session_id) as nb')
                ->from('Welcomebac\StatistiquesBundle\Entity\Statistique', 's')
                ->from('Welcomebac\StatistiquesBundle\Entity\Statistique', 'ass')
                ->where('
                        s.session_id = ass.session_id
                        AND ( ass.campagne=:campagne_annale OR ass.campagne=:campagne_fiche ) 
                        AND s.id_element=:id_element 
                        AND s.campagne=:campagne
                        AND (
                                ass.id_element != :id_element 
                                OR ass.campagne != s.campagne
                        )');
        if(count($associations)){
            $andWhere = "
                        0 = 1 ";
            $ids_assoc = array();
            foreach($associations as $i => $assoc){
                $andWhere .= " 
                        OR (
                                ass.id_element = :id_assoc".$i."
                                AND ass.date > :date_assoc".$i."
                                AND ass.campagne = :campagne_assoc".$i."
                        )";
                $query->setParameter("id_assoc".$i, $assoc['id_element'])
                      ->setParameter("date_assoc".$i, $assoc['date'])
                      ->setParameter("campagne_assoc".$i, (($assoc['type'] == 'annale')?'Acces pdf|Annale':'Acces pdf|Fiche'));
                
                $ids_assoc[] =  $assoc['id_element'];     
            }
            $andWhere = " 
                        (".$andWhere." ) 
                        OR ( 
                                1 = 1";
            foreach($associations as $i => $assoc){
                $andWhere .= " 
                                AND ( 
                                        ass.id_element != :id_assoc".$i." OR ass.campagne != :campagne_assoc".$i." 
                                )";
            }
            $andWhere .= " 
                        )";
            $query->andWhere($andWhere);
        }
        $query = $query->setParameter('campagne_annale', 'Acces pdf|Annale')
              ->setParameter('campagne', $campagne)
              ->setParameter('campagne_fiche', 'Acces pdf|Fiche')
              ->setParameter('id_element', $objet->getId())
              ->groupBy('ass.id_element')
              ->addGroupBy('ass.campagne')
              ->orderBy('nb', 'DESC')
              ->getQuery();
        
        $array = $query->getResult();
        
        //computation des deux tableaux
        foreach ($array as $cle => $el) {
            if ($el['campagne'] == 'Acces pdf|Annale') {
                $type = 'annale';
            } else {
                $type = 'fiche';
            }
            $found = false;
            if(count($associations)){
                foreach($associations as $cle_assoc => $assoc){
                    if($assoc['id_element'] == $el['id_element'] && $type == $assoc['type']){
                        $associations[$cle_assoc]['nb'] += $el['nb'];
                        $found = true;
                        break;
                    }
                }
            }
            if(!$found){
                $associations[] = array(
                    'id_element'    => $el['id_element'], 
                    'nb'            => $el['nb'], 
                    'type'          => $type
                );
            }
        }
        
        //methode de tri
        uasort($associations, function($a, $b){return ($a['nb'] < $b['nb'])?true:false;});
        
        return array_slice($associations, 0, $limite);
    }
    
    /**
     * Permet de recupérer la notation (note et nombre de votes) d'une ressource (fiche ou corrigé)
     * @param Annale/Fiche $objet
     * @return array ('note' => float, 'votes' => integer) 
     */
    public function getNotation($objet){
        if (get_class($objet) == 'Welcomebac\EntitesBundle\Entity\Annale') {
            $type = "corrige";
            $compteur_fiche = 0;
            $compteur_annale = 1;
        } else {
            $type = "fiche";
            $compteur_fiche = 1;
            $compteur_annale = 0;
        }
        
        $query = $this->getEntityManager()
                ->createQueryBuilder();
        
        $query  = $query
                ->select('s.description')
                ->from('Welcomebac\StatistiquesBundle\Entity\Statistique', 's')
                ->where('
                    s.campagne =:campagne_notation_annale AND 1=:compteur_annale
                    OR
                    s.campagne =:campagne_notation_fiche AND 1=:compteur_fiche
                    ')
                ->andWhere($query->expr()->eq('s.id_element', '?1'))
                ->setParameter('campagne_notation_fiche', 'Notation|Fiche')
                ->setParameter('campagne_notation_annale', 'Notation|Corrige')
                ->setParameter('compteur_fiche', $compteur_fiche)
                ->setParameter('compteur_annale', $compteur_annale)
                ->setParameter('1', $objet->getId())
                ->getQuery();
        
        $notations = $query->getResult();
        
        $note = 0;
        $i = 0;
        foreach($notations as $notation){
            $note += $notation['description'];
            $i++;
        }
        
        return array(
            'note' => ($note != 0)?round($note/$i, 1):0,
            'votes'=> $i);
    }
    
    public function updateAssociations($objet, $limite){
        if (get_class($objet) == 'Welcomebac\EntitesBundle\Entity\Annale') {
            $type = "annale";
        } else {
            $type = "fiche";
        }
        
        $associations = $this->getAssociations($objet, 10000);
        
        foreach($associations as $assoc){
            $stat = new \Welcomebac\StatistiquesBundle\Entity\Statistique();
            $stat->setDate(new \DateTime());
            $stat->setDescription($objet->getId().'-'.$assoc['id_element'].'-'.$assoc['nb']);
            $stat->setIp('');
            $stat->setIdElement($objet->getId());
            $stat->setCampagne('Associations|'.ucfirst($type).'-'.ucfirst($assoc['type']));
            $em = $this->getEntityManager();
            $em->persist($stat);
            $em->flush();
        }
        
        return array_slice($associations, 0, $limite);
    }
}