<?php

namespace Welcomebac\StatistiquesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Welcomebac\StatistiquesBundle\Entity\Statistique;


class TraitementsController extends Controller
{
    
    /**
     * Ajout de fausses notations pour les corriges et les fiches
     */
    public function faussesNotationsAction(Request $request, $type)
    {	
        //ini_set('memory_limit', '512M');
        $em = $this->getDoctrine()->getEntityManager();
    	$em = $this->getDoctrine()->getEntityManager();
        $repositoryStats = $em->getRepository('WelcomebacStatistiquesBundle:Statistique');
        
        if($type == 'corrige'){
            $repository = $em->getRepository('WelcomebacEntitesBundle:Annale');
            $campagne 		= "Notation|Corrige";
            $elements = $repository->findByCorrige(1);
        }elseif($type == 'fiche'){
            $repository = $em->getRepository('WelcomebacEntitesBundle:Fiche');
            $campagne 		= "Notation|Fiche";
            $elements = $repository->findAll();
        }
        if(count($elements)){
            foreach($elements as $element){
                $url	 	= $request->request->get('url');
                $referrer 		= $request->request->get('referrer');
                $id_element 	= $element->getId();
                $session_id		= $this->get('session')->getId();
                $ip			= $request->getClientIp();

                $statistique	= new Statistique();
                $statistique->setReferrer($referrer);
                $statistique->setUrl($url);
                $statistique->setSessionId($session_id);
                $statistique->setDate(new \DateTime());
                $statistique->setCampagne($campagne);
                $statistique->setIdElement($id_element);
                $statistique->setIp($ip);
                for($i = 0; $i < rand(41, 51); $i++){
                    $statistique_temp = clone $statistique;
                    $statistique_temp->setDescription(rand(4,5));
                    $em->persist($statistique_temp);
                }
            }
            $em->flush();
        }
        return new Response("Ajout de fausses notations pour les ".$type."s");
    }
    /**
     * Ajout d'entrees dans les stats pour soulager les requetes sur les associations
     * @deprecated Les update sont maintenant fait directement dans le annale via l'action spécifique association
     */
    public function associationMiseajourAction(Request $request, $type)
    {	
    	$em = $this->getDoctrine()->getEntityManager();
        $repositoryStats = $em->getRepository('WelcomebacStatistiquesBundle:Statistique');
        
        if($type == 'annale'){
            $repository = $em->getRepository('WelcomebacEntitesBundle:Annale');
        }elseif($type == 'fiche'){
            $repository = $em->getRepository('WelcomebacEntitesBundle:Fiche');
        }
        $elements_associations = array();
        $elements = $repository->findAll();
        if(count($elements)){
            foreach($elements as $element){
                $elements_associations[$element->getId()] = $repositoryStats->updateAssociations($element, 0);
            }
        }
        $this->render('WelcomebacPublicBundle:Traitements:results.html.twig', array('resultats' => $elements_associations, 'type' => $type));
    }
}
