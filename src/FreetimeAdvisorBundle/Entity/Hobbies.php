<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hobbies
 *
 * @ORM\Table(name="user_hobbies")
 * @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\HobbiesRepository")
 */
class Hobbies
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
    * @ORM\ManyToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="first_category_id", referencedColumnName="id")
    */
    private $first;

    /**
    * @ORM\ManyToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="second_category_id", referencedColumnName="id")
    */
    private $second;

    /**
    * @ORM\ManyToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="third_category_id", referencedColumnName="id")
    */
    private $third;

    /**
    * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
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
     * Set first
     *
     * @param string $first
     *
     * @return Hobbies
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
     * @return Hobbies
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
     * @return Hobbies
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
     * @return Hobbies
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
}
