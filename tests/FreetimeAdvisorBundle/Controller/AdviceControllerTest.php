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


  /* test l'ajout d'un avis */
  public function testNewAdvice()
  {
    // compte les avis en bdd et s'attend à avoir un avis en +
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll()) + 1;

    // instancie un avis
    $advice= new Advice();
    /* Setters */
    $advice->setTitle('Merveilleux!');
    $advice->setComment('Ma description');
    $advice->setScore('5');
    $advice->setPlace($this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON')));
    $advice->setUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    $advice->setCreatedAt(new \DateTime('now'));
    $advice->setUpdatedAt(new \DateTime('now'));
    // ajout de l'avis en bdd
    $this->em->persist($advice);
    $this->em->flush();

    // compte les avis en bdd après ajout
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }

  /* test la modification d'un avis */
  public function testEditAdvice()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));
    // rcherche l'avis à modifier
    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));
    // date d'ajout de l'avis
    $adviceCreatedAt = $advice->getCreatedAt();

    // modification de l'avis
    $editAdvice = $advice;
    $editAdvice
    ->setTitle('Encore plus Merveilleux!')
    ->setUpdatedAt(new \DateTime('now'));
    // modification de l'avis en bdd
    $this->em->persist($editAdvice);
    $this->em->flush();

    // date de modification
    $adviceUpdatedAt = $editAdvice->getUpdatedAt();

    // test passe si les valeurs comparés ne sont pas égales
    $this->assertNotEquals($adviceUpdatedAt, $adviceCreatedAt);

  }


  /* test l'ajout d'une photo */
  public function testNewPhoto()
  {
    // compte les photos en bdd et s'attend à avoir une photo en +
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Photo')->findAll()) + 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));
    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));

    // instancie une nouvelle photo
    $photo = new Photo();

    /* Setters */
    $photo->setName('default.jpg');
    $photo->setUser($user);
    $photo->setPlace($place);
    $photo->setAdvice($advice);
    $photo->setCreatedAt(new \DateTime('now'));

    // ajout d'une photo en bdd
    $this->em->persist($photo);
    $this->em->flush();

    // compte les photos en bdd après ajout
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Photo')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);

  }

  /* test la suppression d'un avis */
  public function testDeleteAdvice()
  {
    // compte les avis en bdd et s'atttend à avoir un avis en -
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll()) - 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CASCADE DU CHAUDRON'));
    // recherche l'avis à supprimer
    $advice = $this->em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));
    // suppression de l'avis
    $this->em->remove($advice);
    $this->em->flush();

    // compte les avis en bdd après suppression
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Advice')->findAll());
    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }


}
