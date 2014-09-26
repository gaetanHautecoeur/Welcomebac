<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class OutilsController extends Controller
{
    
    public function allAction()
    {
        return $this->render('WelcomebacPublicBundle:Outils:all.html.twig');
    }
}
