<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\VariableWidgetAnnale
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class VariableWidgetAnnale
{
	
	/**
     * @ORM\ManyToOne(targetEntity="WidgetAnnale", inversedBy="variables")
     * @ORM\JoinColumn(name="id_widget", referencedColumnName="id")
     */
    protected $widget;
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var text $nom
     *
     * @ORM\Column(name="nom", type="string", length=30)
     */
    private $nom;
    /**
     * @var text $valeur
     *
     * @ORM\Column(name="valeur", type="text")
     */
    private $valeur;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valeur
     *
     * @param text $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return text 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set widget
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetAnnale $widget
     */
    public function setWidget(\Welcomebac\EntitesBundle\Entity\WidgetAnnale $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get widget
     *
     * @return Welcomebac\EntitesBundle\Entity\WidgetAnnale 
     */
    public function getWidget()
    {
        return $this->widget;
    }
}