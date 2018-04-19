<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
* Photo
*
* @ORM\Table(name="place_advices_photos")
* @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\PhotoRepository")
* @Vich\Uploadable
*/
class Photo
{
  /**
  * @var int
  *
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;


  /**
  * @ORM\Column(type="string", length=255,options={"default":"default.jpg"})
  * @var string
  */
  private $name;

  /**
  * @Vich\UploadableField(mapping="place_images", fileNameProperty="name")
  * @var File
  */
  private $imageFile;


  /**
  * @ORM\ManyToOne(targetEntity="User",cascade={"persist"})
  * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
  */
  private $user;

  /**
  * @ORM\ManyToOne(targetEntity="Place", inversedBy="photo")
  * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
  */
  private $place;

  /**
  * @ORM\ManyToOne(targetEntity="Advice",cascade={"persist"})
  * @ORM\JoinColumn(name="advice_id", referencedColumnName="id")
  */
  private $advice;

  /**
  * @ORM\Column(type="datetime",options={"default":0})
  * @var \DateTime
  */
  private $createdAt;


  /**
  * Get id
  *
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  public function setImageFile(File $image = null)
  {
    $this->imageFile = $image;

    // VERY IMPORTANT:
    // It is required that at least one field changes if you are using Doctrine,
    // otherwise the event listeners won't be called and the file is lost
    if ($image) {
      // if 'updatedAt' is not defined in your entity, use another property
      $this->date = new \DateTime('now');
    }
  }

  public function getImageFile()
  {
    return $this->imageFile;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }


  /**
  * Set User
  *
  * @param \FreetimeAdvisorBundle\Entity\User $user
  *
  * @return Photo
  */
  public function setUser(\FreetimeAdvisorBundle\Entity\User $user = null)
  {
    $this->user = $user;
    return $this;
  }
  /**
  * Get User
  *
  * @return \FreetimeAdvisorBundle\Entity\User
  */
  public function getUser()
  {
    return $this->user;
  }

  /**
  * Set Place
  *
  * @param \Blog\RunBlogBundle\Entity\Place $place
  *
  * @return Photo
  */
  public function setPlace(\FreetimeAdvisorBundle\Entity\Place $place = null)
  {
    $this->place = $place;
    return $this;
  }
  /**
  * Get Place
  *
  * @return \FreetimeAdvisorBundle\Entity\Place
  */
  public function getPlace()
  {
    return $this->place;
  }

  /**
  * Set Advice
  *
  * @param \Blog\RunBlogBundle\Entity\Advice $place
  *
  * @return Photo
  */
  public function setAdvice(\FreetimeAdvisorBundle\Entity\Advice $advice = null)
  {
    $this->advice = $advice;
    return $this;
  }
  /**
  * Get Advice
  *
  * @return \FreetimeAdvisorBundle\Entity\Advice
  */
  public function getAdvice()
  {
    return $this->advice;
  }

  public function setCreatedAt()
  {
    $this->createdAt = new \DateTime();
    return $this;
  }
  
  public function getCreatedAt()
  {
    return $this->createdAt;
  }



}
