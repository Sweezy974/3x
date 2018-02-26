<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\PhotoRepository")
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
     * @var string
     *
     * @ORM\Column(name="pathname", type="string", length=255, unique=true)
     */
    private $pathname;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="photo")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="Place", inversedBy="photo")
    * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
    */
    private $place;

    /**
    * @ORM\ManyToOne(targetEntity="Advice", inversedBy="photo")
    * @ORM\JoinColumn(name="advice_id", referencedColumnName="id")
    */
    private $advice;


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
     * Set pathname
     *
     * @param string $pathname
     *
     * @return Photo
     */
    public function setPathname($pathname)
    {
        $this->pathname = $pathname;

        return $this;
    }

    /**
     * Get pathname
     *
     * @return string
     */
    public function getPathname()
    {
        return $this->pathname;
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
}
