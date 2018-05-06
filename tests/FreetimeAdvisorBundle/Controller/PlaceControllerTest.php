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


  /* test l'ajout d'un lieu */
  public function testNewPlace()
  {
    // compte les lieux en bdd et s'attend à avoir un lieu en +
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll()) + 1;

    // instancie un nouveau lieu
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
    // ajout du lieu en bdd
    $this->em->persist($place);
    $this->em->flush();
    // compte les lieux en bdd après l'ajout en bdd
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);


  }

  /* test la modification d'un lieu */
  public function testEditPlace()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $category = $this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DECOUVERTE'));
    $city  = $this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'SAINTE-MARIE'));
    // recherche le lieu à modifier
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('user'=>$user,'city'=>$city,'category'=>$category,'name'=>'AEROPORT DE LA REUNION'));
    // date de création
    $placeCreatedAt = $place->getCreatedAt();
    // modification du lieus
    $editPlace = $place;
    $editPlace
    ->setName('AEROPORT DE GILLOT')
    ->setCreatedAt(new \DateTime('now'));
    // modifie le lieu en bdd
    $this->em->persist($editPlace);
    $this->em->flush();

    // date de modification
    $placeUpdatedAt = $editPlace->getCreatedAt();

    // test passe si les valeurs comparés ne sont pas égales
    $this->assertNotEquals($placeUpdatedAt, $placeCreatedAt);
  }

  /* test la suppression d'un lieu */
  public function testDeletePlace()
  {
    // compte les lieux en bdd et s'attend à avoir un lieu en -
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll()) - 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $category = $this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DECOUVERTE'));
    $city  = $this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'SAINTE-MARIE'));
    // recherche le lieu à supprimer
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('user'=>$user,'city'=>$city,'category'=>$category,'name'=>'AEROPORT DE GILLOT'));
    // suppression du lieu en bdd
    $this->em->remove($place);
    $this->em->flush();
    // compte les lieux en bdd apès suppression
    $actual =count($this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }

}
