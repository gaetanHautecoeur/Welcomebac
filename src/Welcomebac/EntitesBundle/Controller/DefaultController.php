<?php

namespace Welcomebac\EntitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('WelcomebacEntitesBundle:Default:index.html.twig', array('name' => $name));
    }
}
