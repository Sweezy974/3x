<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\City;


class CityTest extends TestCase
{
  protected $city;

  public function setUp()
  {
    $this->city = new city();
  }

  /** @test */
  public function city()
  {
    /* Setters */
    $this->city->setName('PITON SAINT-LEU');
    $this->city->setArea('OUEST');
    $this->city->setZipCode('97424');


    /* Verifying if the getters equals the setters */
    $this->assertEquals($this->city->getName(),'PITON SAINT-LEU');
    $this->assertEquals($this->city->getArea(),'OUEST');
    $this->assertEquals($this->city->getZipCode(),'97424');


  }

}
