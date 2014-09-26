<?php

namespace FOS\FacebookBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Facebook\Facebook;
use Welcomebac\EntitesBundle\Entity\Utilisateur;

class ConnectController extends Controller
{
    public function facebookConnectAction(Request $request)
    {
		if($request->query->get('token') != ''){
			$facebook = $this->container->get('fos_facebook.api');
			$facebook->setAccessToken($request->query->get('token'));
			try {
				$fbdata = $facebook->api('/me');
			} catch (FacebookApiException $e) {
				throw new \Exception('Vous n\'êtes pas connecté à Facebook');
			}
			
			$em = $this->getDoctrine()->getEntityManager();
			$utilisateur = $em->getRepository('WelcomebacEntitesBundle:Utilisateur')->findOneBy(array('id_facebook' => $fbdata['id']));	
			if($utilisateur){
				$utilisateur->setDateConnexion(new \Datetime());
			}else{
				$utilisateur = new Utilisateur();
				$utilisateur->setFbData($fbdata);
				$utilisateur->setDateCreation(new \Datetime());
				$utilisateur->setDateModification(new \Datetime());
			}

			$utilisateur->setDateConnexion(new \Datetime());
			$em->persist($utilisateur);
			$em->flush();
			$this->get('session')->set('utilisateur',$utilisateur->getId());
		}
		$response = new Response(json_encode(array('name' => $utilisateur->getPseudo())));
		$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function facebookDeconnectAction(Request $request)
    {
		if($this->get('session')->has('utilisateur')){
			$this->get('session')->remove('utilisateur');
		}
		$response = new Response(json_encode(array('statut' => true)));
		$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
