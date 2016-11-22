<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Proposition;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Document
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
     * 
     * @ORM\ManyToOne(targetEntity="Proposition",inversedBy="documents", cascade={"persist", "merge", "refresh", "remove"})
     * @ORM\JoinColumn(name="proposition_id",referencedColumnName="id", nullable=false)
     */
    private $proposition;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="doc", type="string", length=255)
     */
    private $doc;
    
    /**
     * @Assert\File(maxSize="9000000000000000", mimeTypes={"image/png", "image/jpeg", "image/gif", "application/pdf", "application/x-pdf"})
     */
    public $file;


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
     * Set name
     *
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set doc
     *
     * @param string $doc
     * @return Document
     */
    public function setDoc($doc)
    {
        $this->doc = $doc;

        return $this;
    }

    /**
     * Get doc
     *
     * @return string 
     */
    public function getDoc()
    {
        return $this->doc;
    }
    
    /**
     * Set proposition
     *
     * @param Proposition $proposition
     *
     * @return Proposition
     */
    public function setProposition( Proposition $proposition = null)
    {
        $this->proposition = $proposition;
    
        return $this;
    }

    /**
     * Get proposition
     *
     * @return Proposition
     */
    public function getProposition()
    {
        return $this->proposition;
    }
    
    public function getAbsoluteDoc()
    {
        return null === $this->doc ? null : $this->getUploadRootDir().'/'.$this->doc;
    }

    public function getWebDoc()
    {
        return null === $this->doc ? null : $this->getUploadDir().'/'.$this->doc;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du rÃ©pertoire oÃ¹ les documents uploadÃ©s doivent Ãªtre sauvegardÃ©s
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se dÃ©barrasse de Â« __DIR__ Â» afin de ne pas avoir de problÃ¨me lorsqu'on affiche
        // le document/image dans la vue.
        return 'bundles/app/document';
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function preUpload()
    {
        
        //var_dump($this);die;
        if (null !== $this->file) {
            // faites ce que vous voulez pour gÃ©nÃ©rer un nom unique
            $this->doc = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
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

        // s'il y a une erreur lors du dÃ©placement du fichier, une exception
        // va automatiquement Ãªtre lancÃ©e par la mÃ©thode move(). Cela va empÃªcher
        // proprement l'entitÃ© d'Ãªtre persistÃ©e dans la base de donnÃ©es si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->doc);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->file = $this->getAbsoluteDoc()) {
            unlink($this->file);
        }
    }
}
