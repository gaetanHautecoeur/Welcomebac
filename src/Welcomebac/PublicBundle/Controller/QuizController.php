<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class QuizController extends Controller
{
    
    public function allAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
		$matieresS = $em->getRepository('WelcomebacEntitesBundle:Matiere')
			->findAllHavingQuiz('S');
		$matieresE = $em->getRepository('WelcomebacEntitesBundle:Matiere')
			->findAllHavingQuiz('E');
		$matieresL = $em->getRepository('WelcomebacEntitesBundle:Matiere')
			->findAllHavingQuiz('L');
    	
        return $this->render('WelcomebacPublicBundle:Quiz:all.html.twig',
        	array("matieresS"=>$matieresS,
        		"matieresE"=>$matieresE,
        		"matieresL"=>$matieresL));
    }
    public function serieMatiereAction($serie, $matiere)
    {
    	$repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
    	$matiere = $repositoryMatiere->findOneBy(array('serie' => $serie,'nom' => $matiere));
    	if(!$matiere){
        	throw $this->createNotFoundException("La liste des quiz par serie et matiere est introuvable");
    	}
        return $this->render('WelcomebacPublicBundle:Quiz:serieMatiere.html.twig', array("matiere" => $matiere));
    }    
    public function quizAction($id, $nb)
    {
    	if($this->getRequest()->getRequestFormat()=='pdf' && $this->get('session')->hasFlash('acces'.$id)){
    		return $this->render('WelcomebacPublicBundle:Accueil:index.html.twig');
    	}
    	$repositoryFiche = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Fiche');
    	$fiche = $repositoryFiche->find($id);
		if(!$fiche){
        	throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
    	}
    	$session = $this->getRequest()->getSession();
    	
    	$fiche->setQuizVisites($fiche->getQuizVisites()+1);
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->flush();
    	
    	
    	$this->get('session')->setFlash('acces'.$id,true);
        return $this->render('WelcomebacPublicBundle:Quiz:quiz.html.twig', array("fiche" => $fiche,"nb"=>$nb));
    }
}
