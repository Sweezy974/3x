<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FosUser;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
* User
*
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\UserRepository")
* @Vich\Uploadable
*/
class User extends FosUser
{
    /**
    *
    * @ORM\Id
    * @ORM\Column(name="id", type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    public function construct()
    {
        parent::__construct();
    }

    /**
    * @var string
    *
    * @ORM\Column(name="description", type="string", length=255, nullable=true)
    */
    private $description;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="birth_date", type="date")
    */
    private $birthDate;

    /**
    * @ORM\Column(type="string", length=255,options={"default":"default.jpg"})
    * @var string
    */
    private $avatar;

    /**
    * @Vich\UploadableField(mapping="user_images", fileNameProperty="avatar")
    * @var File
    */
    private $imageFile;

    /**
    * @ORM\Column(type="datetime",options={"default":0})
    * @var \DateTime
    */
    private $avatarUpdatedAt;

    /**
    * @ORM\ManyToOne(targetEntity="City", cascade={"persist"})
    * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
    */
    private $city;




    /**
    * Get id
    *
    * @return string
    */
    public function getId ()
    {
        return (string) $this->id;
    }

    /**
    * Set description
    *
    * @param string $description
    *
    * @return User
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
    * Set birthDate
    *
    * @param \DateTime $birthDate
    *
    * @return User
    */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
    * Get birthDate
    *
    * @return \DateTime
    */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->avatarUpdatedAt = new \DateTime('now');
        }
    }

    public function setAvatarUpdatedAt($avatarUpdatedAt)
    {
        $this->avatarUpdatedAt = $avatarUpdatedAt;
    }
    public function getAvatarUpdatedAt()
    {
        return $this->avatarUpdatedAt;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
    * Set City
    *
    * @param \FreetimeAdvisorBundle\Entity\City $city
    *
    * @return User
    */
    public function setCity(\FreetimeAdvisorBundle\Entity\City $city = null)
    {
        $this->city = $city;
        return $this;
    }
    /**
    * Get City
    *
    * @return \FreetimeAdvisorBundle\Entity\City
    */
    public function getCity()
    {
        return $this->city;
    }

}
