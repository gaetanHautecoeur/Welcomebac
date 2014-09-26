<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Welcomebac\EntitesBundle\Entity\Document;
use Welcomebac\StatistiquesBundle\Entity\Statistique;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends Controller {

    /**
     * Homepage publique de Welcomebac
     */
    public function indexAction() {
        //recherche des 5 annales les plus visitées
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annales = $repositoryAnnale->findBy(array(), array("nombreVisites" => "DESC"), 5);
        
        //Recherche des 5 fiches les plus consiultées
        $repositoryFiche = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Fiche');
        $fiches = $repositoryFiche->findBy(array(), array("nombreVisites" => "DESC"), 5);

        //Recupération la serie de l'utilisateur en session via un cookie
        $request = $this->getRequest();
        $cookies = $request->cookies->all();
        if (isset($cookies['serie'])) {
            $this->get('session')->set('serie', $cookies['serie']);
        }
        
        //Récupération des Mati?res insérées dans le texte
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matieres['Lit'] = $repositoryMatiere->find(16);
        $matieres['PC'] = $repositoryMatiere->find(10);
        $matieres['SES'] = $repositoryMatiere->find(5);

        return $this->render('WelcomebacPublicBundle:Accueil:index.html.twig', array('annales' => $annales, 'fiches' => $fiches, 'matieres' => $matieres));
    }

    /**
     * Page du formulaire proposant aux utilisateurs de proposer des ressources
     */
    public function ajoutRessourceAction(Request $request) {
        $nom = "";
        $prenom = "";
        $email = "";
        $document = new Document();

        //recuperation des donnees utilisateur si l'utilisateur est connecté
        $utilisateur = $this->get('session')->has('utilisateur');
        if ($utilisateur && ($utilisateur = $this->get('session')->get('utilisateur'))) {
            $repositoryUtilisateur = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Utilisateur');
            $utilisateur = $repositoryUtilisateur->find($utilisateur);
            $nom = $utilisateur->getNom();
            $prenom = $utilisateur->getPrenom();
            $email = $utilisateur->getEmail();
        }
        //Création du formulaire
        $form = $this->createFormBuilder($document)
                ->add('nom', 'text', array('label' => 'Nom', 'required' => false, 'property_path' => false, 'data' => $nom))
                ->add('prenom', 'text', array('label' => 'Prenom', 'required' => false, 'property_path' => false, 'data' => $prenom))
                ->add('email', 'text', array('label' => 'E-mail', 'required' => false, 'property_path' => false, 'data' => $email))
                ->add('titre', 'text', array('label' => 'Titre', 'required' => false))
                ->add('description', 'text', array('label' => 'Description', 'required' => false))
                ->add('file', 'file', array('label' => 'Fichier', 'required' => false))
                ->getForm();

        //Traitement des données POST provenant du formulaire
        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid() && $document->getTitre() != '' && $document->getFile() && $document->getDescription()) {
                //Sauvegarde document en BDD
                $infos = array();
                $infos['titre'] = $document->getTitre();
                $infos['description'] = $document->getDescription();
                $infos['fichier'] = $document->getNomFichier();
                $em = $this->getDoctrine()->getEntityManager();
                $document->setDate(new \DateTime());
                $em->persist($document);
                $em->flush();
                
                //Infos utilisateur
                $nom = $form->get('nom')->getData();
                $prenom = $form->get('prenom')->getData();
                $email = $form->get('email')->getData();
                if ($nom != '' or $prenom != '' or $email != '') {
                    $infos['nom'] = $nom;
                    $infos['prenom'] = $prenom;
                    $infos['email'] = $email;
                }

                //Statistiques
                $statistique = new Statistique();
                $statistique->setDescription(serialize($infos));
                $statistique->setReferrer($request->headers->get('referer'));
                $statistique->setUrl($request->getUri());
                $statistique->setSessionId($this->get('session')->getId());
                $statistique->setDate(new \DateTime());
                $statistique->setCampagne('Ajout Document');
                $statistique->setIdElement($document->getId());
                $statistique->setIp($request->getClientIp());
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($statistique);
                $em->flush();
            }
        }

        return $this->render('WelcomebacPublicBundle:Accueil:ajoutRessource.html.twig', array('form' => $form->createView(), 'uploaded' => (($document->getId()) ? true : false)));
    }

    /**
     * Page CGU
     */
    public function conditionsGeneralesAction() {
        return $this->render('WelcomebacPublicBundle:Accueil:conditionsgenerales.html.twig', array());
    }

    /**
     * Page d'explication sur la creation d'un compte
     */
    public function monCompteAction() {
        return $this->render('WelcomebacPublicBundle:Accueil:moncompte.html.twig', array());
    }

    /**
     * Texte partenaire
     */
    public function partenairesAction() {
        return $this->render('WelcomebacPublicBundle:Accueil:partenaires.html.twig', array());
    }

}
