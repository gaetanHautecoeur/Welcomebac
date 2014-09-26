<?php

namespace Welcomebac\PriveeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Welcomebac\EntitesBundle\Entity\Utilisateur;
use Welcomebac\EntitesBundle\Entity\Favori;


class FavoriController extends Controller
{
    
    public function indexAction(){
		$utilisateur 	= $this->get('session')->has('utilisateur');
			$em 		= $this->getDoctrine()->getEntityManager();
		$repositoryU 	= $em->getRepository('WelcomebacEntitesBundle:Utilisateur');
		if($utilisateur && ($utilisateur = $repositoryU->find($this->get('session')->get('utilisateur')))){
			$repositoryFavori 	= $em->getRepository('WelcomebacEntitesBundle:Favori');
			$fiches 		= $repositoryFavori->findAllRelatedToFiche($utilisateur);
			$annales 		= $repositoryFavori->findAllRelatedToAnnale($utilisateur);
			$corriges 		= $repositoryFavori->findAllRelatedToCorrige($utilisateur);
				return $this->render('WelcomebacPriveeBundle:Favori:index.html.twig',array('fiches' => $fiches, 'annales' => $annales, 'corriges' => $corriges));
		}
        return $this->redirect($this->generateUrl('WelcomebacPublicBundle_monCompte'),302);
    }
    public function supprimerTypeAction($id,$type){
    	$em 		= $this->getDoctrine()->getEntityManager();
		$repositoryF 	= $em->getRepository('WelcomebacEntitesBundle:Favori');
		if(($favori = $repositoryF->findOneBy(array('id_element' => $id, 'type' => $type)))){
			return $this->supprimerAction($favori->getId());
		}
		return $this->indexAction();
    }
    public function supprimerAction($id){
		$utilisateur 	= $this->get('session')->has('utilisateur');
		$em 			= $this->getDoctrine()->getEntityManager();
		$repositoryU 	= $em->getRepository('WelcomebacEntitesBundle:Utilisateur');
		if($utilisateur && ($utilisateur = $repositoryU->find($this->get('session')->get('utilisateur')))){
			$repositoryF 	= $em->getRepository('WelcomebacEntitesBundle:Favori');
			if(($favori = $repositoryF->find($id))){
				$em->remove($favori);
				$em->flush();
			}
		}
		return $this->indexAction();
    }
    public function ajouterAction($id, $type){
		$utilisateur 	= $this->get('session')->has('utilisateur');
			$em 		= $this->getDoctrine()->getEntityManager();
		$repositoryU 	= $em->getRepository('WelcomebacEntitesBundle:Utilisateur');
		$retour = array('statut' => false);
		if($utilisateur && ($utilisateur = $repositoryU->find($this->get('session')->get('utilisateur')))){
			$repositoryF 	= $em->getRepository('WelcomebacEntitesBundle:Favori');
			if(! $repositoryF->findOneBy(array('id_element' => $id, 'type' => $type))){
				$favori			= new Favori();
				$favori->setIdElement($id);
				$favori->setType($type);
				$favori->setUtilisateur($utilisateur);
				$favori->setDateModification(new \DateTime());
				$em->persist($favori);
				$em->flush();
				$retour = array('statut' => true);
			}
		}		
		$response = new Response(json_encode($retour));
		$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function estAction($id, $type){
		$utilisateur 	= $this->get('session')->has('utilisateur');
			$em 		= $this->getDoctrine()->getEntityManager();
		$repositoryU 	= $em->getRepository('WelcomebacEntitesBundle:Utilisateur');
		$retour = array('statut' => false);
		if($utilisateur && ($utilisateur = $repositoryU->find($this->get('session')->get('utilisateur')))){
			$repositoryF 	= $em->getRepository('WelcomebacEntitesBundle:Favori');
			if(! $repositoryF->findOneBy(array('id_element' => $id, 'type' => $type))){
				$retour['estFavori'] = false;
			}else{
				$retour['estFavori'] = true;
			}
		}
		$response = new Response(json_encode($retour));
		$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
