<?php

namespace Tests\FreetimeAdvisorBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\Place;

/**
*
*/
class PlaceRepositoryTest extends WebTestCase
{
  protected $em;

  protected function setUp()
  {
    parent::setUp();
    $this->client = static::createClient();
    $this->container = $this->client->getContainer();
    $this->em = $this->container->get('doctrine')->getManager();
  }

  /* test la récupération de tous les lieux en bdd */
  public function testFindAllPlace()
  {
    // recherche tous les lieux
    $actual = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findAll();
    // total de lieux attendus
    $expected = 11;
    // test passe si les valeurs comparés sont égales
    $this->assertCount($expected,$actual);
  }

  /* test la récupération de tous les lieux d'un utilisateur en bdd */
  public function testFindAllPlaceByUser()
  {
    // recherche l'utilisateur
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'testeur974'));
    // recherche tous les lieux selon l'utilisateur
    $actual =  $this->em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('user'=>$user));
    // total de lieux attendus
    $expected = 3;
    // test passe si les valeurs comparés sont égales
    $this->assertCount($expected,$actual);
  }

  protected function tearDown()
  {
      parent::tearDown();
      // ferme la connexion à la fin des tests
      $this->em->close();
      // évite les fuites de données
      $this->em = null;
  }

}
