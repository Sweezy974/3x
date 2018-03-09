<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Advice
*
* @ORM\Table(name="advice")
* @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\AdviceRepository")
*/
class Advice
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
  * @ORM\Column(name="title", type="string", length=50)
  */
  private $title;

  /**
  * @var string
  *
  * @ORM\Column(name="comment", type="string", length=255)
  */
  private $comment;

  /**
  * @var int
  *
  * @ORM\Column(name="score", type="integer")
  */
  private $score;

  /**
  * @ORM\ManyToOne(targetEntity="Place", inversedBy="advice")
  * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
  */
  private $place;

  /**
  * @ORM\ManyToOne(targetEntity="User", inversedBy="advice")
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
  * Set title
  *
  * @param string $title
  *
  * @return Advice
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
  * Set comment
  *
  * @param string $comment
  *
  * @return Advice
  */
  public function setComment($comment)
  {
    $this->comment = $comment;

    return $this;
  }

  /**
  * Get comment
  *
  * @return string
  */
  public function getComment()
  {
    return $this->comment;
  }

  /**
  * Set score
  *
  * @param integer $score
  *
  * @return Advice
  */
  public function setScore($score)
  {
    $this->score = $score;

    return $this;
  }

  /**
  * Get score
  *
  * @return int
  */
  public function getScore()
  {
    return $this->score;
  }




    public function setPlace(\FreetimeAdvisorBundle\Entity\Place $place = null)
    {
        $this->place = $place;
        return $this;
    }


    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set User
     *
     * @param \FreetimeAdvisorBundle\Entity\User $user
     *
     * @return Advice
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
}
