<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadMatiereData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\Matiere;

class LoadMatiereData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
    	/*
    	 * SERIE Scientifique
    	 */
        $matiere = new Matiere();
        $matiere->setNom("Mathématiques");
        $matiere->setSerie("S");
        $matiere->setCoefficient(7);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('MathsS', $matiere);
        
        $matiere = new Matiere();
        $matiere->setNom("Histoire Géographie");
        $matiere->setSerie("S");
        $matiere->setCoefficient(0);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('HistGeoS', $matiere);
        
        $matiere = new Matiere();
        $matiere->setNom("Philosophie");
        $matiere->setSerie("S");
        $matiere->setCoefficient(2);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('PhiloS', $matiere);
        
    	/*
    	 * SERIE Economie
    	 */
        $matiere = new Matiere();
        $matiere->setNom("Philosophie");
        $matiere->setSerie("E");
        $matiere->setCoefficient(2);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('PhiloES', $matiere);
        
        $matiere = new Matiere();
        $matiere->setNom("Mathématiques");
        $matiere->setSerie("E");
        $matiere->setCoefficient(2);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('MathsES', $matiere);
        
    	/*
    	 * SERIE L
    	 */
        $matiere = new Matiere();
        $matiere->setNom("Littérature");
        $matiere->setSerie("L");
        $matiere->setCoefficient(7);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('LittL', $matiere);
        
        $matiere = new Matiere();
        $matiere->setNom("Mathématiques");
        $matiere->setSerie("L");
        $matiere->setCoefficient(2);
        $matiere->setFacultative(false);
        $manager->persist($matiere);
        $this->addReference('MathsL', $matiere);
        
        $manager->flush();
    }
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}