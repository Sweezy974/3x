<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Category;


class CategoryTest extends TestCase
{
  protected $category;

  public function setUp()
  {
    $this->category = new Category();
  }

  /** @test */
  public function category()
  {
    /* Setters */
    $this->category->setName('CANYONNING');



    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertEquals($this->category->getName(),'CANYONNING');


  }

}
