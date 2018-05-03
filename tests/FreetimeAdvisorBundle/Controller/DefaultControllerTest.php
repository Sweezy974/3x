<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 *
 */
class DefauControllerTest extends WebTestCase
{
  /** @test */
  public function index()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');
    $this->assertContains('Bienvenue sur FreetimeAdvisor', $client->getResponse()->getContent());
  }

}
