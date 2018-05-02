<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\HobbiesList;
use FreetimeAdvisorBundle\Entity\Category;


class HobbiesListTest extends TestCase
{
  protected $hobbies;

  public function setUp()
  {
    $this->hobbies = new HobbiesList();
  }

  /** @test */
  public function hobbiesList()
  {
    /* Setters */
    $this->hobbies->setFirst(new Category());
    $this->hobbies->setSecond(new Category());
    $this->hobbies->setThird(new Category());


    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertInstanceOf(Category::class,$this->hobbies->getFirst());
    $this->assertInstanceOf(Category::class,$this->hobbies->getSecond());
    $this->assertInstanceOf(Category::class,$this->hobbies->getThird());



  }

}
