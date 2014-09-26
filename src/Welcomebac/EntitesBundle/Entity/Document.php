<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Welcomebac\EntitesBundle\Entity\Document
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks/ 
 */
class Document
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
     * @var string $titre
     *
     * @ORM\Column(name="titre", type="string", length=100)
     */
    private $titre;
	
	/**
     * @var object $nom_fichier
     * @ORM\Column(name="nom_fichier", type="string", length=255, nullable=true)
     */
    private $nom_fichier;
	 
	/**
     * @var object $email
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
	 
	/**
     * @var integer $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;	  

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
     * Set titre
     *
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nom_fichier
     *
     * @param file $nomFichier
     */
    public function setNomFichier($nomFichier)
    {
        $this->nom_fichier = $nomFichier;
    }

    /**
     * Get nom_fichier
     *
     * @return file 
     */
    public function getNomFichier()
    {
        return $this->nom_fichier;
    }
	
    /**
     * Set nom_fichier
     *
     * @param file $nomFichier
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get nom_fichier
     *
     * @return file 
     */
    public function getEmail()
    {
        return $this->email;
    }
	
	/*
	*
	*					GESTION DU FICHIER
	*
	*/
	
    
	/**
     * @Assert\File(maxSize="6000000")
     */
	private $file;
	
	/**
     * Set file
     *
     * @param object $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
 
    /**
     * Get file
     *
     * @return object 
     */
    public function getFile()
    {
        return $this->file;
    }
	
	
    public function getAbsolutePath()
    {
        return null === $this->nom_fichier ? null : $this->getUploadRootDir().'/'.$this->nom_fichier;
    }
 
    public function getWebPath()
    {
        return null === $this->nom_fichier ? null : $this->getUploadDir().'/'.$this->nom_fichier;
    }
 
    protected function getUploadRootDir()
    {
        // the absolute directory nom_fichier where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
 
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
	
	
	
	 /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = uniqid().'.'.$this->file->guessExtension();
            $this->setNomFichier($this->file->getClientOriginalName());
        }
    }
 
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        $this->setNomFichier($this->file->getClientOriginalName());
 
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadDir(), $this->nom_fichier);
 
        unset($this->file);
    }
 
   /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}