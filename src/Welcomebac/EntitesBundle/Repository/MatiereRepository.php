<?php 

namespace Welcomebac\EntitesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MatiereRepository extends EntityRepository
{
	public function findAllHavingAnnales($serie){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('m')
		    ->from($this->_entityName,'m')
		    ->join('m.annales','a','ON')
		    ->where('m.serie=:serie')
		    ->setParameter('serie',$serie)
            ->getQuery()
            ->getResult();
	}
	
	public function findAllHavingFiches($serie){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('m')
		    ->from($this->_entityName,'m')
		    ->join('m.fiches','f','ON')
		    ->where('m.serie=:serie')
		    ->setParameter('serie',$serie)
            ->getQuery()
            ->getResult();
	}
	
	public function findAllHavingQuiz($serie){
        return $this->getEntityManager()
        	->createQueryBuilder()
		    ->select('m')
		    ->from($this->_entityName,'m')
		    ->join('m.fiches','f','ON')
		    ->leftJoin('f.questions','q','ON')
		    ->where('m.serie=:serie')
		    ->setParameter('serie',$serie)
            ->getQuery()
            ->getResult();
	}
}