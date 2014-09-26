<?php

namespace Welcomebac\EntitesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentaireCorrigeRepository extends EntityRepository
{
	public function findAllBeingVisible(\Welcomebac\EntitesBundle\Entity\Annale $annale){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('c')
		    ->from($this->_entityName,'c')
		    ->join('c.annale','a','ON')
		    ->where('c.annale=:annale AND c.visible=:visible')
		    ->setParameter('annale',$annale)
		    ->setParameter('visible',true)
            ->getQuery()
            ->getResult();
	}
}