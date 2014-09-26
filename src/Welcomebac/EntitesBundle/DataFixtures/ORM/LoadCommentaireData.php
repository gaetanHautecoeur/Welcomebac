<?php
// src/Acme/HelloBundle/DataFixtures/ORM/LoadFicheData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\CommentaireFiche;
use Welcomebac\EntitesBundle\Entity\CommentaireCorrige;

class LoadCommentaireData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
    	/*
    	 * FICHE
    	 */
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("gaetan.hautecoeur@gmail.com");
        $commentaire->setCommentaire("Vraiment super cette fonctionnalité. Mais manque plus de contenu");
        $commentaire->setVisible(true);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSM_Integrales')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("");
        $commentaire->setCommentaire("Encore une bonne remarque");
        $commentaire->setVisible(true);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSM_Integrales')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("robot@gmail.com");
        $commentaire->setCommentaire("fake");
        $commentaire->setVisible(false);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSM_Integrales')));
        $manager->persist($commentaire);
        
        
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("gaetan.hautecoeur@gmail.com");
        $commentaire->setCommentaire("Vraiment super cette fonctionnalité. Mais manque plus de contenu");
        $commentaire->setVisible(true);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("");
        $commentaire->setCommentaire("Encore une bonne remarque");
        $commentaire->setVisible(true);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireFiche();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("robot@gmail.com");
        $commentaire->setCommentaire("fake");
        $commentaire->setVisible(false);
        $commentaire->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $manager->persist($commentaire);
        /*
         * ANNALE
         */
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("gaetan.hautecoeur@gmail.com");
        $commentaire->setCommentaire("Vraiment super cette fonctionnalité. Mais manque plus de contenu");
        $commentaire->setVisible(true);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSPond2011')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("");
        $commentaire->setCommentaire("Encore une bonne remarque");
        $commentaire->setVisible(true);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSPond2011')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("robot@gmail.com");
        $commentaire->setCommentaire("fake");
        $commentaire->setVisible(false);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSPond2011')));
        $manager->persist($commentaire);
        
        
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("gaetan.hautecoeur@gmail.com");
        $commentaire->setCommentaire("Vraiment super cette fonctionnalité. Mais manque plus de contenu");
        $commentaire->setVisible(true);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSLiban2011')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("");
        $commentaire->setCommentaire("Encore une bonne remarque");
        $commentaire->setVisible(true);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSLiban2011')));
        $manager->persist($commentaire);
        
        $commentaire = new CommentaireCorrige();
        $commentaire->setDate(new \DateTime());
        $commentaire->setAuteur("robot@gmail.com");
        $commentaire->setCommentaire("fake");
        $commentaire->setVisible(false);
        $commentaire->setAnnale($manager->merge($this->getReference('AnnaleMathSLiban2011')));
        $manager->persist($commentaire);
         
        $manager->flush($commentaire);
    }
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}