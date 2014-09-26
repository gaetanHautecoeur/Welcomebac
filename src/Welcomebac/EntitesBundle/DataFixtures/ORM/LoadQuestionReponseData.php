<?php
// src/Acme/HelloBundle/DataFixtures/ORM/LoadFicheData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\Question;
use Welcomebac\EntitesBundle\Entity\Reponse;

class LoadQestionReponseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
    	//QUESTION 1
        $question = new Question();
        $question->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $question->setDescription("Quels états tirent les ficelles de la géopolitique mondiale en 1945 ?");
        $question->setInformations("EU et URSS sont les deux « Super-Grands » (dont les relations commandent les relations internationales)
	l’URSS est une puissance territoriale (elle occupe 1/3 de l’Europe), militaire, et idéologique, accrue par une
	victoire qu’elle a payé au prix fort. Les Etats-Unis cumulent de toutes les formes de puissance : première
	puissance maritime, stratégique, scientifique, suprématie éco et financière, modèle de la démocratie libérale
	qui impose ses valeurs à l’Europe.");
        
        $reponse = new Reponse();
        $reponse->setDescription("Etats-Unis et Royaume-Uni");
        $reponse->setCorrecte(false);
        $question->addReponses($reponse);
        
        $reponse = new Reponse();
        $reponse->setDescription("Etats-Unis et Japon");
        $reponse->setCorrecte(false);
        $question->addReponses($reponse);
        
        $reponse = new Reponse();
        $reponse->setDescription("Etats-Unis et URSS");
        $reponse->setCorrecte(true);
        $question->addReponses($reponse);
        
        $manager->persist($question);
        
        
    	//QUESTION 2
        $question = new Question();
        $question->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $question->setDescription("Quels dirigeants participent à la conférence de Yalta en février 1945 ?");
        $question->setInformations("");
        $manager->persist($question);
        
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Attlee Truman Staline");
        $reponse->setCorrecte(false);
        $manager->persist($reponse);
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Staline Roosevelt Churchill");
        $reponse->setCorrecte(true);
        $manager->persist($reponse);
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Staline Churchill Truman");
        $reponse->setCorrecte(false);
        $manager->persist($reponse);
        
    	//QUESTION 3
        $question = new Question();
        $question->setFiche($manager->merge($this->getReference('FicheSHG_GMI')));
        $question->setDescription("Quelle charte fut établie lors de la première conférence de San Francisco ?");
        $question->setInformations("L’idée maitresse qui présidait à la création de l’Organisation des Nations Unies était la préservation de la
paix. Le 25 avril 1945, à San Francisco, la Chine, les EU, la France, le RU et l’URSS (ainsi que 45 autres pays)
signaient la charte des nations unies dans laquelle est affirmée l’égalité souveraine de tous les membres, ainsi
que la coopération internationale et le développement des droits fondamentaux de l’homme.");
        $manager->persist($question);
        
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Charte des Nation Unies");
        $reponse->setCorrecte(true);
        $manager->persist($reponse);
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Traité de paix entre le japon et le plus grand nombre de ses anciens adversaires");
        $reponse->setCorrecte(false);
        $manager->persist($reponse);
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setDescription("Charte de l’Atlantique");
        $reponse->setCorrecte(false);
        $manager->persist($reponse);
  
        $manager->flush();
    }
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}