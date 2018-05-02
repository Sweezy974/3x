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
    $this->favorites->setPlace(new Place());
    $this->favorites->setUser(new User());


    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertInstanceOf(Place::class,$this->favorites->getPlace());
    $this->assertInstanceOf(User::class,$this->favorites->getUser());


  }

}
