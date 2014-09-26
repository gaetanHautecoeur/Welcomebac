<?php

namespace Welcomebac\JoshfactoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Welcomebac\StatistiquesBundle\Entity\Statistique;

class FluxController extends Controller
{
	//Creation du sitemap
    public function fichesAction(Request $request, $matiere, $serie)
    {
		
    	$em = $this->getDoctrine()->getEntityManager();
    	//Recuperation de la matiere
    	$repositoryMatiere = $em->getRepository('WelcomebacEntitesBundle:Matiere');
    	$matiere = $repositoryMatiere->findOneBy(array('url' => $matiere, 'serie' => $serie));
		if(!$matiere){
        	throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
    	}
	
		$repositoryFiche = $em->getRepository('WelcomebacEntitesBundle:Fiche');
    	$fiches = $repositoryFiche->findBy(array('matiere' => $matiere->getId()),array('titre' => 'DESC'));
		$tab = array();
		foreach($fiches as $fiche){
			$tab[] = array(
				'itemType'		=> "Article",
				'id'			=> $fiche->getId(),
				'url'			=> $this->generateUrl('WelcomebacPublicBundle_fiche', array('serie'=>$fiche->getMatiere()->getSerie(), 'matiere' => $fiche->getMatiere()->getUrl(), 'titre' => $fiche->getUrl())),
				'name' 			=> $fiche->getTitre(),
				'articleBody'	=> $fiche->getDescription().'<img style="display:none;" src="'.$this->generateUrl('WelcomebacStatistiquesBundle_ajouterHtml', array('campagne'=>'Appli Visits|Fiche', 'id_element' => $fiche->getId(), 'description' => 'matiere:'.$matiere->getNom().',serie:'.$matiere->getSerie()), true).'">',
				"publisher"		=> array
					(
					"itemType"	=> "Organization",
					"url"		=> "http://www.welcomebac.com/",
					"name"		=> "WelcomeBac"
					)
				);
		}
		//Statistiques
		$statistique	= new Statistique();
		$statistique->setDescription('matiere:'.$matiere->getNom().',serie:'.$matiere->getSerie());
		$statistique->setReferrer($request->headers->get('referer'));
		$statistique->setUrl($request->getUri());
		$statistique->setSessionId($this->get('session')->getId());
		$statistique->setDate(new \DateTime());
		$statistique->setCampagne('Appli Visits|Fiches');
		$statistique->setIdElement(1);
		$statistique->setIp($request->getClientIp());
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($statistique);
		$em->flush();
		
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode($tab));
		$response->headers->set('Access-Control-Allow-Origin','* HTTP');
        return $response;
	}
	
	//annales de la serie et de la matiere
    public function annalesAction(Request $request, $serie, $matiere)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	//Recuperation de la matiere
    	$repositoryMatiere = $em->getRepository('WelcomebacEntitesBundle:Matiere');
    	$matiere = $repositoryMatiere->findOneBy(array('url' => $matiere, 'serie' => $serie));
		if(!$matiere){
        	throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
    	}
    	$repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
		$annales = $repositoryAnnale->findBy(
		    array('matiere' => $matiere->getId()),
			array('date' => 'DESC')
		);
		$tab = array();
		foreach($annales as $annale){
			$tab[] = array(
				'itemType'		=> 'Article',
				'name' 			=> $annale->getLieu()."<br/>".$annale->getDate(),
				'articleBody'	=> $this->generateUrl('WelcomebacPublicBundle_annale', array('serie'=>$annale->getMatiere()->getSerie(), 'matiere' => $annale->getMatiere()->getUrl(), 'lieu' => $annale->getLieuUrl(), 'annee'=>$annale->getDate())),
				"publisher"		=> array
					(
					"itemType"	=> "Organization",
					"url"		=> "http://www.welcomebac.com/",
					"name"		=> "WelcomeBac"
					)
				);
		}
		//Statistiques
		$statistique	= new Statistique();
		$statistique->setDescription('matiere:'.$matiere->getNom().',serie:'.$matiere->getSerie());
		$statistique->setReferrer($request->headers->get('referer'));
		$statistique->setUrl($request->getUri());
		$statistique->setSessionId($this->get('session')->getId());
		$statistique->setDate(new \DateTime());
		$statistique->setCampagne('Appli Visits|Annales');
		$statistique->setIdElement($matiere->getId());
		$statistique->setIp($request->getClientIp());
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($statistique);
		$em->flush();
		
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode($tab));
		$response->headers->set('Access-Control-Allow-Origin','* HTTP');
        return $response;
	}
	
	//corriges de la serie et de la matiere
    public function corrigesAction(Request $request, $serie, $matiere)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	//Recuperation de la matiere
    	$repositoryMatiere = $em->getRepository('WelcomebacEntitesBundle:Matiere');
    	$matiere = $repositoryMatiere->findOneBy(array('url' => $matiere, 'serie' => $serie));
		if(!$matiere){
        	throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
    	}
    	$repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
		$annales = $repositoryAnnale->findBy(
		    array('matiere' => $matiere->getId(), 'corrige' => 1),
			array('date' => 'DESC')
		);
		$tab = array();
		foreach($annales as $annale){
			$tab[] = array(
				'itemType'		=> 'Article',
				'name' 			=> $annale->getLieu()."<br/>".$annale->getDate(),
				'articleBody'	=> $this->generateUrl('WelcomebacPublicBundle_corrige', array('serie'=>$annale->getMatiere()->getSerie(), 'matiere' => $annale->getMatiere()->getUrl(), 'lieu' => $annale->getLieuUrl(), 'annee'=>$annale->getDate())),
				"publisher"		=> array
					(
					"itemType"	=> "Organization",
					"url"		=> "http://www.welcomebac.com/",
					"name"		=> "WelcomeBac"
					)
				);
		}
		//Statistiques
		$statistique	= new Statistique();
		$statistique->setDescription('matiere:'.$matiere->getNom().',serie:'.$matiere->getSerie());
		$statistique->setReferrer($request->headers->get('referer'));
		$statistique->setUrl($request->getUri());
		$statistique->setSessionId($this->get('session')->getId());
		$statistique->setDate(new \DateTime());
		$statistique->setCampagne('Appli Visits|Corriges');
		$statistique->setIdElement($matiere->getId());
		$statistique->setIp($request->getClientIp());
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($statistique);
		$em->flush();
		
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode($tab));
		$response->headers->set('Access-Control-Allow-Origin','* HTTP');
        return $response;
	}
}
