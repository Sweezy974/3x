<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Favorites;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\User;


class FavoritesTest extends TestCase
{
  protected $favorites;

  public function setUp()
  {
    $this->favorites = new Favorites();
  }

  /** @test */
  public function favorites()
  {
    /* Setters */
    $this->favorites->setPlaceId(new Place());
    $this->favorites->setUserId(new User());


    /* Verifying if the getters equals the setters */
    $this->assertInstanceOf(Place::class,$this->favorites->getPlaceId());
    $this->assertInstanceOf(User::class,$this->favorites->getUserId());


  }

}
