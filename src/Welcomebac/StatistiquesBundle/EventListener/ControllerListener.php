<?php

namespace Welcomebac\StatistiquesBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 *
 * @author Gaetan Hautecoeur
 */
class ControllerListener
{
    public function __construct()
    {
    }
    public function onKernelController(FilterControllerEvent $event)
    {
    	/*
        $request = $event->getRequest();
        if($request->attributes->get("_stats")){
        	echo $request->attributes->get("_stats");
        }
        */
    }
}
