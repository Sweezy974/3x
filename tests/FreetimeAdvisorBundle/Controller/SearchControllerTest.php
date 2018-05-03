<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\Place;

/**
 *
 */
class SearchControllerTest extends WebTestCase
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
  public function searchPlace()
  {
    $user= new Place();
    $user->setName('LE REX');
    $this->em->persist($user);
    $this->em->flush();

  }

}
