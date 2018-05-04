<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\Place;

/**
*
*/
class PlaceControllerTest extends WebTestCase
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
  public function newPlace()
  {
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll()) + 1;

    $place= new Place();
    /* Setters */
    $place->setName('AEROPORT DE LA REUNION');
    $place->setDescription('Ma description');
    $place->setLocation('non loin du port de Sainte-Marie');
    $place->setCity($this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'SAINTE-MARIE')));
    $place->setCategory($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DECOUVERTE')));
    $place->setUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    $place->setCreatedAt(new \DateTime('now'));
    $place->setMainPhoto('default.jpg');
    $this->em->persist($place);
    $this->em->flush();
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll());

    $this->assertEquals($expected, $actual);
    // $this->em->remove($place);
    // $this->em->flush();


  }

  /** @test */
  public function editPlace()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $category = $this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DECOUVERTE'));
    $city  = $this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'SAINTE-MARIE'));

    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('user'=>$user,'city'=>$city,'category'=>$category,'name'=>'AEROPORT DE LA REUNION'));
    $placeCreatedAt = $place->getCreatedAt();
    $editPlace = $place;
    $editPlace
    ->setName('AEROPORT DE GILLOT')
    ->setCreatedAt(new \DateTime('now'));
    $this->em->persist($editPlace);
    $this->em->flush();
    $placeUpdatedAt = $editPlace->getCreatedAt();


    $this->assertNotEquals($placeUpdatedAt, $placeCreatedAt);
    // $this->em->remove($editPlace);
    // $this->em->flush();
  }
  /** @test */

  public function deletePlace()
  {
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll()) - 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $category = $this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DECOUVERTE'));
    $city  = $this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'SAINTE-MARIE'));

    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('user'=>$user,'city'=>$city,'category'=>$category,'name'=>'AEROPORT DE GILLOT'));

    $this->em->remove($place);
    $this->em->flush();
    
    $actual =count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll());


    $this->assertEquals($expected, $actual);
  }

}
