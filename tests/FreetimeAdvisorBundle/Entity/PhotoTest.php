<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Photo;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\User;


class PhotoTest extends TestCase
{
  protected $photo;

  public function setUp()
  {
    $this->photo = new Photo();
  }

  /** @test */
  public function photo()
  {
    /* Setters */
    $this->photo->setName('place-image.jpg');
    $this->photo->setPlace(new Place());
    $this->photo->setAdvice(new Advice());
    $this->photo->setUser(new User());
    $this->photo->setCreatedAt(new \DateTime());


    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertEquals($this->photo->getName(),'place-image.jpg');
    $this->assertInstanceOf(Place::class,$this->photo->getPlace());
    $this->assertInstanceOf(Advice::class,$this->photo->getAdvice());
    $this->assertInstanceOf(User::class,$this->photo->getUser());
    $this->assertInstanceOf(\DateTime::class,$this->photo->getCreatedAt());

  }

}
