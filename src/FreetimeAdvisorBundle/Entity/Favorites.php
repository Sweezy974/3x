<?php

namespace FreetimeAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Favorites
*
* @ORM\Table(name="favorites")
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
  * @ORM\ManyToOne(targetEntity="User", inversedBy="favorites")
  * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
  */
  private $userId;


  /**
  * @ORM\ManyToOne(targetEntity="Place", inversedBy="favorites")
  * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
  */
  private $placeId;


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
  * Set userId
  *
  * @param integer $userId
  *
  * @return Favorites
  */
  public function setUserId($userId)
  {
    $this->userId = $userId;

    return $this;
  }

  /**
  * Get userId
  *
  * @return int
  */
  public function getUserId()
  {
    return $this->userId;
  }

  /**
  * Set placeId
  *
  * @param integer $placeId
  *
  * @return Favorites
  */
  public function setPlaceId($placeId)
  {
    $this->placeId = $placeId;

    return $this;
  }

  /**
  * Get placeId
  *
  * @return int
  */
  public function getPlaceId()
  {
    return $this->placeId;
  }
}
