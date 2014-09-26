<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Annale
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\AnnaleRepository")
 */
class Annale
{
	/**
     * @ORM\ManyToMany(targetEntity="Fiche", mappedBy="annalesRecommandees")
     */
    protected $fichesRecommandees;
	/**
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="annales")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id")
     */
    protected $matiere;
    
    /**
     * @ORM\OneToMany(targetEntity="TagAnnale", mappedBy="annale")
     */
    protected $tags;
    /**
     * @ORM\OneToMany(targetEntity="WidgetAnnale", mappedBy="annale")
     */
    protected $widgets;
    /**
     * @ORM\OneToMany(targetEntity="CommentaireCorrige", mappedBy="annale")
     */
    protected $commentairesCorrige;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $date
     *
     * @ORM\Column(name="date", type="string")
     */
    private $date;

    /**
     * @var string $lieu
     *
     * @ORM\Column(name="lieu", type="string", length=50)
     */
    private $lieu;

	/**
     * @var integer $duree
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;
    
    /**
     * @var boolean $corrige
     *
     * @ORM\Column(name="corrige", type="boolean")
     */
    private $corrige;
    
	/**
     * @var integer $nombreVisites
     *
     * @ORM\Column(name="nombreVisites", type="integer")
     */
    private $nombreVisites;
    
	/**
     * @var integer $contenu
     *
     * @ORM\Column(name="contenu", type="text", nullable=true)
     */
    private $contenu;
	/**
     * @var integer $facebookTitle
     *
     * @ORM\Column(name="facebookTitle", type="text", nullable=true)
     */
    private $facebookTitle;
	
    /**
     * @var string $id_wb
     *
     * @ORM\Column(name="id_wb", type="string", length=150, nullable=true)
     */
    private $id_wb;
		
    /**
     * @var string $lieu_url
     *
     * @ORM\Column(name="lieu_url", type="string", length=150, nullable=true)
     */
    private $lieu_url;

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
     * Set date
     *
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set corrige
     *
     * @param boolean $corrige
     */
    public function setCorrige($corrige)
    {
        $this->corrige = $corrige;
    }

    /**
     * Get corrige
     *
     * @return boolean 
     */
    public function getCorrige()
    {
        return $this->corrige;
    }

    /**
     * Set matiere
     *
     * @param Welcomebac\EntitesBundle\Entity\Matiere $matiere
     */
    public function setMatiere(\Welcomebac\EntitesBundle\Entity\Matiere $matiere)
    {
        $this->matiere = $matiere;
    }

    /**
     * Get matiere
     *
     * @return Welcomebac\EntitesBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tags
     *
     * @param Welcomebac\EntitesBundle\Entity\TagAnnale $tags
     */
    public function addTags(\Welcomebac\EntitesBundle\Entity\TagAnnale $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add widgets
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetAnnale $widgets
     */
    public function addWidgets(\Welcomebac\EntitesBundle\Entity\WidgetAnnale $widgets)
    {
        $this->widgets[] = $widgets;
    }

    /**
     * Get widgets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * Add commentairesCorrige
     *
     * @param Welcomebac\EntitesBundle\Entity\CommentaireCorrige $commentairesCorrige
     */
    public function addCommentairesCorrige(\Welcomebac\EntitesBundle\Entity\CommentaireCorrige $commentairesCorrige)
    {
        $this->commentairesCorrige[] = $commentairesCorrige;
    }

    /**
     * Get commentairesCorrige
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCommentairesCorrige()
    {
        return $this->commentairesCorrige;
    }

    /**
     * Add fichesRecommandees
     *
     * @param Welcomebac\EntitesBundle\Entity\Fiche $fichesRecommandees
     */
    public function addFichesRecommandees(\Welcomebac\EntitesBundle\Entity\Fiche $fichesRecommandees)
    {
        $this->fichesRecommandees[] = $fichesRecommandees;
    }

    /**
     * Get fichesRecommandees
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFichesRecommandees()
    {
        return $this->fichesRecommandees;
    }

    /**
     * Set nombreVisites
     *
     * @param integer $nombreVisites
     */
    public function setNombreVisites($nombreVisites)
    {
        $this->nombreVisites = $nombreVisites;
    }

    /**
     * Get nombreVisites
     *
     * @return integer 
     */
    public function getNombreVisites()
    {
        return $this->nombreVisites;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set contenu
     *
     * @param text $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * Get contenu
     *
     * @return text 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set facebookTitle
     *
     * @param text $facebookTitle
     */
    public function setFacebookTitle($facebookTitle)
    {
        $this->facebookTitle = $facebookTitle;
    }

    /**
     * Get facebookTitle
     *
     * @return text 
     */
    public function getFacebookTitle()
    {
        return $this->facebookTitle;
    }

    /**
     * Set id_wb
     *
     * @param string $idWb
     */
    public function setIdWb($idWb)
    {
        $this->id_wb = $idWb;
    }

    /**
     * Get id_wb
     *
     * @return string 
     */
    public function getIdWb()
    {
        return $this->id_wb;
    }
	
    /**
     * Set lieu_url
     *
     * @param string $idWb
     */
    public function setLieuUrl($lieuUrl)
    {
        $this->lieu_url = $lieuUrl;
    }

    /**
     * Get lieu_url
     *
     * @return string 
     */
    public function getLieuUrl()
    {
        return $this->lieu_url;
    }
}