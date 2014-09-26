<?php
// src/Acme/HelloBundle/DataFixtures/ORM/LoadAnnaleData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\Annale;

class LoadAnnaleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
    	/*
    	 * SERIE S
    	 */
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('MathsS')));
        $annale->setDate("2011");
        $annale->setLieu("Liban");
        $annale->setCorrige(true);
        $annale->setNombreVisites(50);
        $annale->setDuree(4);
        $manager->persist($annale);
        $this->addReference('AnnaleMathSLiban2011', $annale);
        
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('MathsS')));
        $annale->setDate("2011");
        $annale->setLieu("Pondichéry");
        $annale->setCorrige(true);
        $annale->setNombreVisites(12);
        $annale->setDuree(4);
        $manager->persist($annale);
        $this->addReference('AnnaleMathSPond2011', $annale);
        
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('PhiloS')));
        $annale->setDate("2011");
        $annale->setLieu("Pondichéry");
        $annale->setCorrige(true);
        $annale->setNombreVisites(105);
        $annale->setDuree(4);
        $manager->persist($annale);
        $this->addReference('AnnalePhiloSPond2011', $annale);
        
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('PhiloS')));
        $annale->setDate("2006");
        $annale->setLieu("Liban");
        $annale->setCorrige(true);
        $annale->setNombreVisites(15);
        $annale->setDuree(4);
        $manager->persist($annale);
        $this->addReference('AnnalePhiloSLiban2006', $annale);
        
    	/*
    	 * SERIE ES
    	 */
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('PhiloES')));
        $annale->setDate("2008");
        $annale->setLieu("France Métropolitaine");
        $annale->setCorrige(false);
        $annale->setNombreVisites(0);
        $annale->setDuree(4);
        $manager->persist($annale);
        
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('PhiloES')));
        $annale->setDate("2011");
        $annale->setLieu("Pondichéry");
        $annale->setCorrige(false);
        $annale->setNombreVisites(15);
        $annale->setDuree(4);
        $manager->persist($annale);   
         
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('MathsES')));
        $annale->setDate("2011");
        $annale->setLieu("Pondichéry");
        $annale->setCorrige(false);
        $annale->setNombreVisites(100);
        $annale->setDuree(4);
        $manager->persist($annale);   	 
    	 
    	/*
    	 * SERIE L
    	 */
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('LittL')));
        $annale->setDate("2008");
        $annale->setLieu("France Métropolitaine");
        $annale->setCorrige(false);
        $annale->setNombreVisites(120);
        $annale->setDuree(4);
        $manager->persist($annale);
        
        $annale = new Annale();
        $annale->setMatiere($manager->merge($this->getReference('MathsL')));
        $annale->setDate("2011");
        $annale->setLieu("Pondichéry");
        $annale->setCorrige(false);
        $annale->setNombreVisites(75);
        $annale->setDuree(4);
        $manager->persist($annale);
        $manager->flush();
    }
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}