<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Hobbies;
use FreetimeAdvisorBundle\Entity\Category;


class HobbiesTest extends TestCase
{
  protected $hobbies;

  public function setUp()
  {
    $this->hobbies = new Hobbies();
  }

  /** @test */
  public function hobbies()
  {
    /* Setters */
    $this->hobbies->setFirst(new Category());
    $this->hobbies->setSecond(new Category());
    $this->hobbies->setThird(new Category());


    /* Verifying if the getters equals the setters */
    $this->assertInstanceOf(Category::class,$this->hobbies->getFirst());
    $this->assertInstanceOf(Category::class,$this->hobbies->getSecond());
    $this->assertInstanceOf(Category::class,$this->hobbies->getThird());



  }

}
