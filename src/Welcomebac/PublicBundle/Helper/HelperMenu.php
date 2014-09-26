<?php

namespace Welcomebac\PublicBundle\Helper ;

use Symfony\Component\Templating\Helper\Helper ;

class HelperMenu extends Helper
{
    public function doSomething($myString)
    {
         // Do something with $myString
         return $myString ; 
    }

    public function getName()
    {
        return 'HelperMenu' ;
    }
}
