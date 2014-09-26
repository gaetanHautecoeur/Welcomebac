<?php
// src/Acme/HelloBundle/DataFixtures/ORM/LoadAnnaleData.php
namespace Welcomebac\EntitesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Welcomebac\EntitesBundle\Entity\WidgetAnnale;
use Welcomebac\EntitesBundle\Entity\VariableWidgetAnnale;

class LoadWidgetnnaleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
    	/*
    	 * Exemple philoS 1
    	 */
        $widgetAnnaleParent = new WidgetAnnale();
        $widgetAnnaleParent->setTwig("WidgetsAnnale:philo");
        $widgetAnnaleParent->setAnnale($manager->merge($this->getReference('AnnalePhiloSPond2011')));
        $widgetAnnaleParent->setOrdre(0);
        $manager->persist($widgetAnnaleParent);        
        $manager->flush();
    	/*
    	 * Titre 1
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSPond2011')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(0);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur('La culture rend-elle libre ?');
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
    	/*
    	 * Titre 2
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSPond2011')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(1);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur("Est-ce un devoir que de s'efforcer d'être heureux ?");
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
    	/*
    	 * Titre 3 avec extrait
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSPond2011')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(2);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur('Explication de texte');
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('consigne');
        $widgetVariable->setValeur("La connaissance de la doctrine de l'auteur n'est pas requise. Il faut et il suffit que l'explication rende compte, par la compréhension précise du texte, du problème dont il est question.");
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
        
	        $extrait = new WidgetAnnale();
	        $extrait->setTwig("WidgetsExtrait:texte");
	        $extrait->setAnnale($manager->merge($this->getReference('AnnalePhiloSPond2011')));
	        $extrait->setParent($widgetAnnale);
	        $extrait->setOrdre(0);
	        $manager->persist($extrait);
	        $manager->flush();
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('titre');
	        $widgetVariable->setValeur('La conscience et la vie');
	        $widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('auteur');
	        $widgetVariable->setValeur('Bergson');
	        $widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('texte');
	        $widgetVariable->setValeur("Mettons donc matière et conscience en pré­sence l’une de l’autre : nous verrons que la matière est d’abord ce qui divise et ce qui précise. Une pensée, laissée à elle-même, offre une implication récipro­que d’éléments dont on ne peut dire qu’ils soient un ou plusieurs : c’est une continuité, et dans toute continuité il y a de la confusion. Pour que la pensée devienne distincte, il faut bien qu’elle s’éparpille en mots : nous ne nous ren­dons bien compte de ce que nous avons dans l’esprit que lorsque nous avons pris une feuille de papier, et aligné les uns à côté des autres des termes qui s’entrepénétraient. Ainsi la matière distingue, sépare, résout en individualités et finalement en personnalités des tendances jadis confondues dans l’élan originel de la vie. D’autre part, la matière provoque et rend possible l’effort. La pensée qui n’est que pensée, l’œuvre d’art qui n’est que conçue, le poème qui n’est que rêvé, ne coûtent pas encore de la peine ; c’est la réalisation matérielle du poème en mots, de la conception artistique en statue ou tableau, qui demande un effort. L’effort est pénible, mais il est aussi précieux, plus pré­cieux encore que l’œuvre où il aboutit, parce que, grâce à lui, on a tiré de soi plus qu’il n’y avait, on s’est haussé au-dessus de soi-même. Or, cet effort n’eût pas été possible sans la matière : par la résistance qu’elle oppose et par la docilité où nous pouvons l’amener, elle est à la fois l’obstacle, l’instrument et le stimulant ; elle éprouve notre force, en garde l’empreinte et en appelle l’intensification.");
	        $widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $manager->flush();
        
    	
    	/*
    	 * Exemple philoS 2
    	 */
        $widgetAnnaleParent = new WidgetAnnale();
        $widgetAnnaleParent->setTwig("WidgetsAnnale:philo");
        $widgetAnnaleParent->setAnnale($manager->merge($this->getReference('AnnalePhiloSLiban2006')));
        $widgetAnnaleParent->setOrdre(0);
        $manager->persist($widgetAnnaleParent);        
        $manager->flush();
    	/*
    	 * Titre 1
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSLiban2006')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(0);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur("Est-il plus difficile de connaître l'esprit que la matière ?");
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
    	/*
    	 * Titre 2
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSLiban2006')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(1);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur("Le désir de liberté peut-il conduire à perdre sa liberté ?");
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
    	/*
    	 * Titre 3 avec extrait
    	 */
        $widgetAnnale = new WidgetAnnale();
        $widgetAnnale->setTwig("WidgetsSujet:philo");
        $widgetAnnale->setAnnale($manager->merge($this->getReference('AnnalePhiloSLiban2006')));
        $widgetAnnale->setParent($widgetAnnaleParent);
        $widgetAnnale->setOrdre(2);
        $manager->persist($widgetAnnale);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('titre');
        $widgetVariable->setValeur('Explication de texte');
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
        $widgetVariable = new VariableWidgetAnnale();
        $widgetVariable->setNom('consigne');
        $widgetVariable->setValeur("La connaissance de la doctrine de l'auteur n'est pas requise. Il faut et il suffit que l'explication rende compte, par la compréhension précise du texte, du problème dont il est question.");
        $widgetVariable->setWidget($widgetAnnale);
        $manager->persist($widgetVariable);
        $manager->flush();
        
	        $extrait = new WidgetAnnale();
	        $extrait->setTwig("WidgetsExtrait:texte");
	        $extrait->setAnnale($manager->merge($this->getReference('AnnalePhiloSLiban2006')));
	        $extrait->setParent($widgetAnnale);
	        $extrait->setOrdre(0);
	        $manager->persist($extrait);
	        $manager->flush();
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('titre');
	        $widgetVariable->setValeur('Critique de la raison pure');
	        $widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('auteur');
	        $widgetVariable->setValeur('Kant');
	        $widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $widgetVariable = new VariableWidgetAnnale();
	        $widgetVariable->setNom('texte');
	        $widgetVariable->setValeur("Il y a dans la nature humaine une certaine fausseté qui doit, en définitive, comme tout ce qui vient de la nature, aboutir à de bonnes fins, je veux parler de notre inclination à cacher nos vrais sentiments et à faire parade de certains autres supposés, que nous tenons pour bons et honorables. Il est très certain que ce penchant, qui porte les hommes à dissimuler et en même temps à prendre une apparence avantageuse, les a non seulement civilisés, mais encore moralisés peu à peu, dans une certaine mesure, parce que personne ne pouvait pénétrer à travers le fard de la décence, de l'honorabilité et de la moralité. On trouva alors, dans les prétendus bons exemples qu'on voyait autour de soi, une école d'amélioration pour soi-même. Mais cette disposition à se faire passer pour meilleur qu'on ne l'est et à manifester des sentiments que l'on n'a pas, ne sert que provisoirement, en quelque sorte, à dépouiller l'homme de sa rudesse et à lui faire prendre au moins tout d'abord l'apparence du bien qu'il connaît ; car, une fois que les bons principes sont développés et qu'ils sont passés dans la manière de penser, cette fausseté doit alors être peu à peu combattue avec vigueur, car autrement elle corrompt le coeur et étouffe les bons sentiments sous l'ivraie de la belle apparence.");
			$widgetVariable->setWidget($extrait);
	        $manager->persist($widgetVariable);
	        $manager->flush();
    }
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}