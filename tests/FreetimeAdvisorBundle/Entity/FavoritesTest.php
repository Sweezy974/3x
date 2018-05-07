<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Favorite;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\User;


class FavoriteTest extends TestCase
{
  protected $favorite;

  public function setUp()
  {
    $this->favorite = new Favorite();
  }

  /** @test */
  public function favorite()
  {
    /* Setters */
    $this->favorite->setPlace(new Place());
    $this->favorite->setUser(new User());
    $this->favorite->setCreatedAt(new \DateTime());


    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertInstanceOf(Place::class,$this->favorite->getPlace());
    $this->assertInstanceOf(User::class,$this->favorite->getUser());
    $this->assertInstanceOf(\DateTime::class,$this->favorite->getCreatedAt());


  }

}
