<?php

namespace Welcomebac\StatistiquesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\StatistiquesBundle\Entity\Statistique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\StatistiquesBundle\Repository\StatistiqueRepository")
 */
class Statistique{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string $campagne
     *
     * @ORM\Column(name="campagne", type="string", length=50)
     */
    private $campagne;

	/**
     * @var text $referrer
     *
     * @ORM\Column(name="referrer", type="string", length=255, nullable=true)
     */
    private $referrer;
	
	/**
     * @var text $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
    
	/**
     * @var text $session_id
     *
     * @ORM\Column(name="session_id", type="string", length=255)
     */
    private $session_id;
    
	/**
     * @var integer $id_element
     *
     * @ORM\Column(name="id_element", type="string", length=20, nullable=true)
     */
    private $id_element;
    
    /**
     * @var string $ip
     *
     * @ORM\Column(name="ip", type="string", length=15)
     */

    private $ip;
	
	/**
     * @var text $referer
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
	
	

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
     * Set campagne
     *
     * @param string $campagne
     */
    public function setCampagne($campagne)
    {
        $this->campagne = $campagne;
    }

    /**
     * Get campagne
     *
     * @return string 
     */
    public function getCampagne()
    {
        return $this->campagne;
    }

    /**
     * Set referer
     *
     * @param string $referer
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set url
     *
     * @param string $url
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
    /**
     * Set session_id
     *
     * @param string $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * Set id_element
     *
     * @param string $idElement
     */
    public function setIdElement($idElement)
    {
        $this->id_element = $idElement;
    }

    /**
     * Get id_element
     *
     * @return integer 
     */
    public function getIdElement()
    {
        return $this->id_element;
    }

    /**
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
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
}