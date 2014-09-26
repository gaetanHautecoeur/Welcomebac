<?php

namespace Welcomebac\EntitesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WelcomebacPublic\EntitesBundle\Fiche;
use WelcomebacPublic\EntitesBundle\Annale;
use WelcomebacPublic\EntitesBundle\Utilisateur;

class FavoriRepository extends EntityRepository
{
	public function findAllRelatedToFiche($utilisateur){
		$fiches = array();
    		$em 		= $this->getEntityManager();
		$repository 	= $em->getRepository('WelcomebacEntitesBundle:Fiche');
        	foreach($utilisateur->getFavoris() as $favori){
			if($favori->getType() == 'f'){
				$fiches[] = $repository->find($favori->getIdElement());	
			}
		}
		return $fiches;
	}
	public function findAllRelatedToAnnale($utilisateur){
		$annales = array();
    		$em 		= $this->getEntityManager();
		$repository 	= $em->getRepository('WelcomebacEntitesBundle:Annale');
        	foreach($utilisateur->getFavoris() as $favori){
			if($favori->getType() == 'a'){
				$annales[] = $repository->find($favori->getIdElement());	
			}
		}
		return $annales;
	}
	public function findAllRelatedToCorrige($utilisateur){
		$annales = array();
    		$em 		= $this->getEntityManager();
		$repository 	= $em->getRepository('WelcomebacEntitesBundle:Annale');
        	foreach($utilisateur->getFavoris() as $favori){
			if($favori->getType() == 'c'){
				$annales[] = $repository->find($favori->getIdElement());	
			}
		}
		return $annales;
	}
}
