<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\City;
use FreetimeAdvisorBundle\Entity\Category;
use FreetimeAdvisorBundle\Entity\User;


class PlaceTest extends TestCase
{
  protected $place;

  public function setUp()
  {
    $this->place = new Place();
  }

  /** @test */
  public function Place()
  {
    /* Setters */
    $this->place->setName('Aéroport de la Réunion');
    $this->place->setDescription('Ma description');
    $this->place->setLocation('non loin du port de Sainte-Marie');
    $this->place->setCity(new City());
    $this->place->setCategory(new Category());
    $this->place->setUser(new User());
    $this->place->setDate(new \DateTime());


    /* Verifying if the getters equals the setters */
    $this->assertEquals($this->place->getName(),'Aéroport de la Réunion');
    $this->assertEquals($this->place->getDescription(),'Ma description');
    $this->assertEquals($this->place->getLocation(),'non loin du port de Sainte-Marie');
    $this->assertInstanceOf(City::class,$this->place->getCity());
    $this->assertInstanceOf(Category::class,$this->place->getCategory());
    $this->assertInstanceOf(User::class,$this->place->getUser());
    $this->assertInstanceOf(\DateTime::class,$this->place->getDate());

  }

}
