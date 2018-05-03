<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\City;
use FreetimeAdvisorBundle\Entity\HobbiesList;
use Symfony\Component\HttpFoundation\Request;
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
  public function registration()
  {
    $user= new User();
    $expected['user'] = count($this->em->getRepository('FreetimeAdvisorBundle:User')->findAll()) + 1;
    /* Setters */
    $user->setUsername('Fred');
    $user->setEmail('frederic@gmail.com');
    $user->setPassword(password_hash("pwd", PASSWORD_DEFAULT));
    $user->setDescription('Ma description');
    $user->setBirthdate(new \DateTime('1995-01-01'));
    $user->setAvatar('avatar.jpg');
    $user->setCity($this->em->getRepository('FreetimeAdvisorBundle:City')->findOneBy(array('name'=>'LE PORT')));
    $user->setAvatarUpdatedAt(new \DateTime('now'));
    $this->em->persist($user);
    $this->em->flush();
    $actual['user'] = count($this->em->getRepository('FreetimeAdvisorBundle:User')->findAll());

    $this->assertEquals($expected, $actual);
    // $this->em->remove($user);
    // $this->em->flush();


  }

  /** @test */
  public function selectHobbies()
  {
    $hobbiesList = new hobbiesList();
    $expected['hobbies'] = count($this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findAll()) + 1;
    /* Setters */
    $hobbiesList->setFirst($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'NATURE')));
    $hobbiesList->setSecond($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DIVERTISSEMENT')));
    $hobbiesList->setThird($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'RESTAURATION')));
    $hobbiesList->setUpdatedAt(new \DateTime('now'));
    $hobbiesList->SetUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    $this->em->persist($hobbiesList);
    $this->em->flush();
    $actual['hobbies'] = count($this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findAll());

    $this->assertEquals($expected, $actual);
    // $this->em->remove($hobbiesList);
    // $this->em->flush();


  }

  /** @test */
  public function editHobbies()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $hobbiesList = $this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneBy(array('user'=>$user));
    $ActualHobbiesListDate = $hobbiesList->getUpdatedAt();
    $ExpectedHobbiesList = $this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneBy(array('id'=>$hobbiesList));
    $ExpectedHobbiesList->setUpdatedAt(new \DateTime('now'));
    $this->em->persist($ExpectedHobbiesList);
    $this->em->flush();

    $ExpectedHobbiesListDate = $ExpectedHobbiesList->getUpdatedAt();

    $this->assertNotEquals($ExpectedHobbiesListDate, $ActualHobbiesListDate);
    $this->em->remove($ExpectedHobbiesList);
    $this->em->flush();


  }

  // /** @test */
  // public function login()
  // {
  //   $request = Request();
  //   $pwd = password_hash("1234", PASSWORD_DEFAULT);
  //   $client = static::createClient(array(), array(
  //     'PHP_AUTH_USER' => 'user974',
  //     'PHP_AUTH_PW'   => $pwd,
  //   ));
  //   $currentPassword = $request->get('PHP_AUTH_PW');
  //   $encoder = $this->container->get('security.password_encoder');
  //   $match = $encoder->isPasswordValid($pwd, $currentPassword);
  //   dump($match);
  //
  //
  //   $expected = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974','password'=>'$2y$13$cSIuTklm56v5f/TjbaEhROPvh.iBy11.gTrbhlJRQW1JbHAVcxhui'));
  //
  //   $this->assertEquals($expected, $client);
  // }

  public function tearDown()
  {
    parent::tearDown();
    $this->em->close();
    $this->em = null;
  }
}
