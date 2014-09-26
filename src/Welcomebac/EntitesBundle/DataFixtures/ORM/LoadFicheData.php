<?php
// src/Acme/HelloBundle/DataFixtures/ORM/LoadFicheData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\Fiche;

class LoadFicheData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $fiche = new Fiche();
        $fiche->setMatiere($manager->merge($this->getReference('MathsS')));
        $fiche->setTitre("Les Intégrales");
        $fiche->setDescription("Bien définir les intégrale");
        $fiche->setDate(new \DateTime());
        $fiche->setNombreVisites(12);
        $fiche->setQuizVisites(17);
        $fiche->addAnnalesRecommandees($manager->merge($this->getReference('AnnaleMathSPond2011')));
        $this->addReference('FicheSM_Integrales', $fiche);
        $manager->persist($fiche);
        
        $fiche = new Fiche();
        $fiche->setMatiere($manager->merge($this->getReference('HistGeoS')));
        $fiche->setTitre("Le monde au lendemain de la GMI");
        $fiche->setDescription("Bien définir les intégrale");
        $fiche->setDate(new \DateTime());
        $fiche->setNombreVisites(102);
        $fiche->setQuizVisites(10);
        $manager->persist($fiche);
        $this->addReference('FicheSHG_GMI', $fiche);
        
        $manager->flush();
    }
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}