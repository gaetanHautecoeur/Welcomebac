<?php

namespace Welcomebac\StatistiquesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Welcomebac\StatistiquesBundle\Entity\Statistique;


class StatistiqueController extends Controller
{
    
    public function ajouterAjaxAction(Request $request)
    {	
		$retour = array('statut' => false);
		
		if($request->query->get('robot') == "false"){
			$url	 		= $request->request->get('url');
			$campagne 		= $request->request->get('campagne');
			$referrer 		= $request->request->get('referrer');
			$description 	= $request->request->get('description');
			$id_element 	= $request->request->get('id_element');
			$session_id		= $this->get('session')->getId();
			$ip				= $request->getClientIp();
			try{
				$statistique	= new Statistique();
				$statistique->setDescription($description);
				$statistique->setReferrer($referrer);
				$statistique->setUrl($url);
				$statistique->setSessionId($session_id);
				$statistique->setDate(new \DateTime());
				$statistique->setCampagne($campagne);
				$statistique->setIdElement($id_element);
				$statistique->setIp($ip);
			
			
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($statistique);
				$em->flush();
				$retour['statut'] = true;
			}catch(\Exception $e){
				$retour['statut'] = false;
			}
		}
		
		$response = new Response(json_encode($retour));
		$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function ajouterHtmlAction(Request $request)
    {	
		$url	 		= $request->query->get('url');
		$campagne 		= $request->query->get('campagne');
		$referrer 		= $request->query->get('referrer');
		$description 	= $request->query->get('description');
		$id_element 	= $request->query->get('id_element');
		$session_id		= $this->get('session')->getId();
		$ip				= $request->getClientIp();
		
		$statistique	= new Statistique();
		$statistique->setDescription($description);
		$statistique->setReferrer($referrer);
		$statistique->setUrl($url);
		$statistique->setSessionId($session_id);
		$statistique->setDate(new \DateTime());
		$statistique->setCampagne($campagne);
		$statistique->setIdElement($id_element);
		$statistique->setIp($ip);
	
	
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($statistique);
		$em->flush();
		
		$response = new Response();
        return $response;
    }
}
