<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HobbiesList
 *
 * @ORM\Table(name="user_hobbies_list")
 * @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\HobbiesListRepository")
 */
class HobbiesList
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
    * @ORM\OneToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="first_category_id", referencedColumnName="id")
    */
    private $first;

    /**
    * @ORM\OneToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="second_category_id", referencedColumnName="id")
    */
    private $second;

    /**
    * @ORM\OneToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="third_category_id", referencedColumnName="id")
    */
    private $third;

    /**
    * @ORM\OneToOne(targetEntity="User")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\Column(type="datetime",options={"default":0})
    * @var \DateTime
    */
    private $updatedAt;


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
     * Set first
     *
     * @param string $first
     *
     * @return HobbiesList
     */
    public function setFirst($first)
    {
        $this->first = $first;

        return $this;
    }

    /**
     * Get first
     *
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Set second
     *
     * @param string $second
     *
     * @return HobbiesList
     */
    public function setSecond($second)
    {
        $this->second = $second;

        return $this;
    }

    /**
     * Get second
     *
     * @return string
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * Set third
     *
     * @param string $third
     *
     * @return HobbiesList
     */
    public function setThird($third)
    {
        $this->third = $third;

        return $this;
    }

    /**
     * Get third
     *
     * @return string
     */
    public function getThird()
    {
        return $this->third;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return HobbiesList
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt= new \DateTime();
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
