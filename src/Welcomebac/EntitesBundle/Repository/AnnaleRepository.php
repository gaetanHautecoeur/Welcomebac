<?php

namespace Welcomebac\EntitesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WelcomebacPublic\EntitesBundle\Fiche;

class AnnaleRepository extends EntityRepository
{
	public function findAllNotRecommendedTo($fiche){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('a')
		    ->from($this->_entityName,'a')
            ->getResult();
	}
	
}