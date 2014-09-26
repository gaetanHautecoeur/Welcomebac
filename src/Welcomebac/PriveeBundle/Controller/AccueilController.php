<?php

namespace Welcomebac\PriveeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Welcomebac\EntitesBundle\Entity\Utilisateur;


class AccueilController extends Controller
{
    public function connexionAction()
    {
        return $this->render('WelcomebacPriveeBundle:Accueil:connexion.html.twig', array());
    }
    public function enregistrementAction()
    {
        return $this->render('WelcomebacPriveeBundle:Accueil:enregistrement.html.twig', array());
    }
}
