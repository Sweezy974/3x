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



    /* Verifying if the getters equals the setters */
    $this->assertEquals($this->category->getName(),'CANYONNING');


  }

}
