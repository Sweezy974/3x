<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Photo;

/**
*
*/
class AdviceControllerTest extends WebTestCase
{
  protected $em;

  protected function setUp()
  {
    parent::setUp();
    $this->client = static::createClient();
    $this->container = $this->client->getContainer();
    $this->em = $this->container->get('doctrine')->getManager();
  }


  /** @test */
  public function newAdvice()
  {
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll()) + 1;

    $advice= new Advice();
    /* Setters */
    $advice->setTitle('Merveilleux!');
    $advice->setComment('Ma description');
    $advice->setScore('5');
    $advice->setPlace($this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON')));
    $advice->setUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    $advice->setCreatedAt(new \DateTime('now'));
    $this->em->persist($advice);
    $this->em->flush();
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll());

    $this->assertEquals($expected, $actual);
    // $this->em->remove($advice);
    // $this->em->flush();


  }

  /** @test */
  public function editAdvice()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));
    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));
    $adviceCreatedAt = $advice->getCreatedAt();
    $editAdvice = $advice;
    $editAdvice
    ->setTitle('Encore plus Merveilleux!')
    ->setCreatedAt(new \DateTime('now'));
    $this->em->persist($editAdvice);
    $this->em->flush();
    $adviceUpdatedAt = $editAdvice->getCreatedAt();


    $this->assertNotEquals($adviceUpdatedAt, $adviceCreatedAt);
    // $this->em->remove($editAdvice);
    // $this->em->flush();
  }


  /** @test */
  public function newPhoto()
  {
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Photo')->findAll()) + 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));

    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));

    $photo = new Photo();

    /* Setters */
    $photo->setName('default.jpg');
    $photo->setUser($user);
    $photo->setPlace($place);
    $photo->setAdvice($advice);
    $photo->setCreatedAt(new \DateTime('now'));

    $this->em->persist($photo);
    $this->em->flush();
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Photo')->findAll());

    $this->assertEquals($expected, $actual);
    // $this->em->remove($advice);
    // $this->em->flush();


  }
  
  /** @test */
  public function deleteAdvice()
  {
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll()) - 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));

    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));

    $this->em->remove($advice);
    $this->em->flush();

    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll());


    $this->assertEquals($expected, $actual);
  }


}
