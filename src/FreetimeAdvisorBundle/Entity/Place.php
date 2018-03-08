<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\PlaceRepository")
 */
class Place
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
    * @ORM\ManyToOne(targetEntity="City", inversedBy="place")
    * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
    */
    private $city;

    /**
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="place")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    private $category;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="place")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Place
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
     * Set location
     *
     * @param string $location
     *
     * @return Place
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Place
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
     * Set City
     *
     * @param \FreetimeAdvisorBundle\Entity\City $city
     *
     * @return Place
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

    /**
     * Set Category
     *
     * @param \FreetimeAdvisorBundle\Entity\Category $category
     *
     * @return Place
     */
    public function setCategory(\FreetimeAdvisorBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }
    /**
     * Get Category
     *
     * @return \FreetimeAdvisorBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }


    public function setUser(\FreetimeAdvisorBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }




}
