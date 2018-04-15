<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Favorites
*
* @ORM\Table(name="user_favorites")
* @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\FavoritesRepository")
*/
class Favorites
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
  * @ORM\ManyToOne(targetEntity="User",cascade={"persist"})
  * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
  */
  private $user;


  /**
  * @ORM\ManyToOne(targetEntity="Place",cascade={"persist"})
  * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
  */
  private $place;


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
  * Set user
  *
  * @param integer $user
  *
  * @return Favorites
  */
  public function setUser($user)
  {
    $this->user = $user;

    return $this;
  }

  /**
  * Get user
  *
  * @return int
  */
  public function getUser()
  {
    return $this->user;
  }

  /**
  * Set place
  *
  * @param integer $place
  *
  * @return Favorites
  */
  public function setPlace($place)
  {
    $this->place = $place;

    return $this;
  }

  /**
  * Get place
  *
  * @return int
  */
  public function getPlace()
  {
    return $this->place;
  }
}
