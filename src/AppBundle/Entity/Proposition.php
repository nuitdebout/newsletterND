<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Proposition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Proposition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="string", length=140)
     */
    private $teaser;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=50, nullable=true)
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="typeProposition", type="string", length=50)
     */
    private $typeProposition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="date", nullable=true)
     */
    private $deadline;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
 * @var string
 *
 * @ORM\Column(name="description", type="text", nullable=true)
 */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", options={"default":true})
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer", nullable=true, options={"unsigned":true, "default":0})
     */
    private $ordre;
    
    /**
    * @ORM\OneToMany(targetEntity="Document", mappedBy="proposition", cascade={"persist", "merge", "refresh", "remove"})
    */

    protected $documents;
    
    
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Proposition
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     * @return Proposition
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string 
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Proposition
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
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
 * Set lieu
 *
 * @param string $lieu
 * @return Proposition
 */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
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
     * Set theme
     *
     * @param string $theme
     * @return Proposition
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return Proposition
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     * @return Proposition
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set typeProposition
     *
     * @param string $typeProposition
     * @return Proposition
     */
    public function setTypeProposition($typeProposition)
    {
        $this->typeProposition = $typeProposition;

        return $this;
    }

    /**
     * Get typeProposition
     *
     * @return string
     */
    public function getTypeProposition()
    {
        return $this->typeProposition;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Proposition
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Proposition
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Proposition
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    /**
    * Add document
    *
    * @param Document $document
    */
   public function addDocument(Document $document)
   {
       $this->documents[] = $document;
   }
   
   /**
    * Remove documents
    *
    * @param Document $documents
    */
  public function removeDocument(Document $document)
  {
    $this->documents->removeElement($document);
  }

   /**
    * Get documents
    *
    * @return ArrayCollection
    */
   public function getDocuments()
   {
       return $this->documents;
   }
   
   /**
    * Set documents
    *
    * @param ArrayCollection $documents
    */
   public function setDocuments(ArrayCollection $documents)
   {
       $this->documents = $documents;
   }
}
