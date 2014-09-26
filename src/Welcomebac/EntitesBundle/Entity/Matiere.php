<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Matiere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\MatiereRepository")
 */
class Matiere
{
	
	/**
     * @ORM\OneToMany(targetEntity="Annale", mappedBy="matiere")
     */
    protected $annales;
    
	/**
     * @ORM\OneToMany(targetEntity="Fiche", mappedBy="matiere")
	 * @ORM\OrderBy({"nombreVisites" = "DESC"})
     */
    protected $fiches;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;
    
    /**
     * @var string $nom_abrege
     *
     * @ORM\Column(name="nom_abrege", type="string", length=4, nullable=true)
     */
    private $nom_abrege;

    /**
     * @var string $serie
     *
     * @ORM\Column(name="serie", type="string", length=2)
     */
    private $serie;

    /**
   	* @ORM\Column(columnDefinition="integer unsigned") 
     */
    private $coefficient;

    /**
     * @var boolean $facultative
     *
     * @ORM\Column(name="facultative", type="boolean")
     */
    private $facultative;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=150, nullable=true)
     */
    private $url;

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
     * Set serie
     *
     * @param string $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * Get serie
     *
     * @return string 
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set coefficient
     *
     * @param integer $coefficient
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;
    }

    /**
     * Get coefficient
     *
     * @return integer 
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set facultative
     *
     * @param boolean $facultative
     */
    public function setFacultative($facultative)
    {
        $this->facultative = $facultative;
    }

    /**
     * Get facultative
     *
     * @return boolean 
     */
    public function getFacultative()
    {
        return $this->facultative;
    }
    public function __construct()
    {
        $this->annales = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fiches = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add annales
     *
     * @param Welcomebac\EntitesBundle\Entity\Annale $annales
     */
    public function addAnnales(\Welcomebac\EntitesBundle\Entity\Annale $annales)
    {
        $this->annales[] = $annales;
    }

    /**
     * Get annales
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAnnales()
    {
        return $this->annales;
    }
    
    /**
     * Add fiches
     *
     * @param Welcomebac\EntitesBundle\Entity\Fiche $fiches
     */
    public function addFiches(\Welcomebac\EntitesBundle\Entity\Fiche $fiches)
    {
        $this->fiches[] = $fiches;
    }

    /**
     * Get fiches
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFiches()
    {
        return $this->fiches;
    }
    
    public function __toString(){
    	return $this->nom;
    }

    /**
     * Set nom_abrege
     *
     * @param string $nomAbrege
     */
    public function setNomAbrege($nomAbrege)
    {
        $this->nom_abrege = $nomAbrege;
    }

    /**
     * Get nom_abrege
     *
     * @return string 
     */
    public function getNomAbrege()
    {
        return $this->nom_abrege;
    }
	
    /**
     * Set url
     *
     * @param string $nomAbrege
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}