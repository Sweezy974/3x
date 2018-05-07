<?php

namespace Tests\FreetimeAdvisorBundle\Entity;

use PHPUnit\Framework\TestCase;
// use Symfony\Component\HttpFoundation\File\File;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\City;


class UserTest extends TestCase
{
  protected $user;

  public function setUp()
  {
    $this->user = new User();
  }

  /** @test */
  public function User()
  {
    /* Setters */
    $this->user->setUsername('Fred');
    $this->user->setEmail('frederic@gmail.com');
    $this->user->setPassword('pwd');
    $this->user->setDescription('Ma description');
    $this->user->setBirthdate(new \DateTime);
    $this->user->setAvatar('avatar.jpg');
    $this->user->setCity(new City());
    $this->user->setAvatarUpdatedAt(new \DateTime);

    /* Vérifie si les données obtenues en sortie sont égales à ceux inscrites en entrée  */

    $this->assertEquals($this->user->getUsername(),'Fred');
    $this->assertEquals($this->user->getEmail(),'frederic@gmail.com');
    $this->assertEquals($this->user->getPassword(),'pwd');
    $this->assertEquals($this->user->getDescription(),'Ma description');
    $this->assertEquals($this->user->getAvatar(),'avatar.jpg');
    $this->assertInstanceOf(City::class,$this->user->getCity());
    $this->assertInstanceOf(\DateTime::class,$this->user->getBirthdate());
    $this->assertInstanceOf(\DateTime::class,$this->user->getAvatarUpdatedAt());

  }

}
