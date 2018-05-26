<?php
// run test in cmd: ./vendor/bin/simple-phpunit .\tests\FreetimeAdvisorBundle\Entity
namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\Photo;


class AdviceTest extends TestCase
{
  protected $advice;

  public function setUp()
  {
    $this->advice = new advice();
  }

  /** @test */
  public function advice()
  {
    /* Setters */
    $this->advice->setTitle('Très bien');
    $this->advice->setComment('Mon commentaire');
    $this->advice->setScore(5);
    $this->advice->setPlace(new Place());
    $this->advice->setUser(new User());
    $this->advice->setCreatedAt(new \DateTime());
    $this->advice->setUpdatedAt(new \DateTime());
    $this->advice->setPhoto(new Photo());


    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */
    $this->assertEquals($this->advice->getTitle(),'Très bien');
    $this->assertEquals($this->advice->getComment(),'Mon commentaire');
    $this->assertEquals($this->advice->getScore(),5);
    $this->assertInstanceOf(Place::class,$this->advice->getPlace());
    $this->assertInstanceOf(User::class,$this->advice->getUser());
    $this->assertInstanceOf(\DateTime::class,$this->advice->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class,$this->advice->getUpdatedAt());
    $this->assertInstanceOf(Photo::class,$this->advice->getPhoto());

  }

}
