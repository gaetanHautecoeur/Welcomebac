<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Utilisateur
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Utilisateur
{
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
     * @ORM\OneToMany(targetEntity="Favori", mappedBy="utilisateur", cascade={"all"})
     */
    protected $favoris;
	
    /**
     * @var string $pseudo
     *
     * @ORM\Column(name="pseudo", type="string", length=150)
     */
    private $pseudo;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=150)
     */
    private $nom;
	
    /**
     * @var string $prenom
     *
     * @ORM\Column(name="prenom", type="string", length=150)
     */
    private $prenom;
	
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=150, nullable="true")
     */
    private $email;
	
    /**
     * @var string $date_modification
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    private $date_modification;
	
    /**
     * @var string $date_connexion
     *
     * @ORM\Column(name="date_connexion", type="datetime")
     */
    private $date_connexion;
	
    /**
     * @var string $date_creation
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     * @var string $id_facebook
     *
     * @ORM\Column(name="id_facebook", type="string", length=250)
     */
    private $id_facebook;
	
    public function __construct()
    {
        $this->favoris = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set pseudo
     *
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Get pseudo
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date_modification
     *
     * @param datetime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->date_modification = $dateModification;
    }

    /**
     * Get date_modification
     *
     * @return datetime 
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * Set date_connexion
     *
     * @param datetime $dateConnexion
     */
    public function setDateConnexion($dateConnexion)
    {
        $this->date_connexion = $dateConnexion;
    }

    /**
     * Get date_connexion
     *
     * @return datetime 
     */
    public function getDateConnexion()
    {
        return $this->date_connexion;
    }

    /**
     * Set date_creation
     *
     * @param datetime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;
    }

    /**
     * Get date_creation
     *
     * @return datetime 
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * Add favoris
     *
     * @param Welcomebac\EntitesBundle\Entity\Favori $favoris
     */
    public function addFavoris(\Welcomebac\EntitesBundle\Entity\Favori $favoris)
    {
        $this->favoris[] = $favoris;
    }

    /**
     * Get favoris
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFavoris()
    {
        return $this->favoris;
    }
	

    /**
     * Set prenom
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set id_facebook
     *
     * @param string $idFacebook
     */
    public function setIdFacebook($idFacebook)
    {
        $this->id_facebook = $idFacebook;
    }

    /**
     * Get id_facebook
     *
     * @return string 
     */
    public function getIdFacebook()
    {
        return $this->id_facebook;
    }

    public function setFbData($fbdata){
	
	if (isset($fbdata['id'])) {
		$this->setIdFacebook($fbdata['id']);
	}
	if (isset($fbdata['name'])) {
		$this->setPseudo($fbdata['name']);
	}
	if (isset($fbdata['last_name'])) {
		$this->setNom($fbdata['last_name']);
	
	}
	if (isset($fbdata['first_name'])) {	
		$this->setPrenom($fbdata['first_name']);
	}
	if (isset($fbdata['email'])) {
		$this->setEmail($fbdata['email']);
	}
    }	

}
