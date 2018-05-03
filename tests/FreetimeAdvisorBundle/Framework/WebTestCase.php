<?php

namespace Tests\FreetimeAdvisorBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;


/**
 *
 */
class WebTestCase extends BaseWebTestCase
{
  protected $em;

  protected $client;

  protected $container;

  protected $crawler;


  protected function setUp()
  {
    parent::setUp();
    $this->client = static::createClient();
    $this->container = $this->client->getContainer();
    $this->em = $this->container->get('doctrine')->getManager();
    static $metadatas = null;

    if (is_null($metadatas)) {
      $metadatas = $this->$em->getMetadataFactory()->getAllMetadata();
    }

    $schemaTool = new SchemaTool($this->em);
    $schemaTool->dropDatabase();

    if(!empty($metadatas)){
      $schemaTool->createSchema($metadatas);
    }
  }

  // protected function onNotSuccessfulTest(Throwable $t)
  // {
  //   if ($this->crawler && $this->crawler->filter('.exception-message')->count() > 0) {
  //     $throwableClass = get_class($t);
  //     $message = $this->crawler->filter('.exception-message')->eq(0)->text();
  //     throw new $throwableClass($t->getMessage() . ' | ' . $message);
  //   }
  //
  //   throw $t;
  //
  // }
  protected function tearDown()
  {
    parent::tearDown();
    $this->em->close();
    $this->em = null;
  }
}
