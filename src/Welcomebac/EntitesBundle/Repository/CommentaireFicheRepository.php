<?php

namespace Welcomebac\EntitesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentaireFicheRepository extends EntityRepository
{
	public function findAllBeingVisible(\Welcomebac\EntitesBundle\Entity\Fiche $fiche){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('c')
		    ->from($this->_entityName,'c')
		    ->join('c.fiche','f','ON')
		    ->where('c.fiche=:fiche AND c.visible=:visible')
		    ->setParameter('fiche',$fiche)
		    ->setParameter('visible',true)
            ->getQuery()
            ->getResult();
	}
}