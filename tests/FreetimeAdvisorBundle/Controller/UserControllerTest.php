<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\City;

/**
*
*/
class DefauControllerTest extends WebTestCase
{
  protected $em;


  protected function setUp()
  {
    parent::setUp();
    $this->client = static::createClient();
    $this->container = $this->client->getContainer();
    $this->em = $this->container->get('doctrine')->getManager();

    // $schemaTool = new SchemaTool($this->em);
    // $schemaTool->dropDatabase();
    // $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
    // $schemaTool->createSchema($metadatas);
  }


  /** @test */
  public function newUser()
  {
    $expected = array();
    $actual = array();

    $city= new City();
    $expected['city'] = count($this->em->getRepository('FreetimeAdvisorBundle:City')->findAll()) + 1;
    $city->setName('LE PORT')
    ->setZipCode('97420')
    ->setArea('OUEST');
    $this->em->persist($city);
    $this->em->flush();
    $actual['city'] = count($this->em->getRepository('FreetimeAdvisorBundle:City')->findAll());

    $user= new User();
    $expected['user'] = count($this->em->getRepository('FreetimeAdvisorBundle:User')->findAll()) + 1;
    /* Setters */
    $user->setUsername('Fred');
    $user->setEmail('frederic@gmail.com');

    $user->setPassword(password_hash("pwd", PASSWORD_DEFAULT));
    $user->setDescription('Ma description');
    $user->setBirthdate(new \DateTime('1995-01-01'));
    $user->setAvatar('avatar.jpg');
    $user->setCity($city);
    $user->setAvatarUpdatedAt(new \DateTime('now'));
    $this->em->persist($user);
    $this->em->flush();
    $actual['user'] = count($this->em->getRepository('FreetimeAdvisorBundle:User')->findAll());

    $this->assertEquals($expected, $actual);
    $this->em->remove($user);
    $this->em->remove($city);
    $this->em->flush();


  }

  public function tearDown()
  {
    parent::tearDown();
    $this->em->close();
    $this->em = null;
  }
}
