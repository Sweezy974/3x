<?php

namespace Tests\FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\City;
use FreetimeAdvisorBundle\Entity\HobbiesList;
use FreetimeAdvisorBundle\Entity\Favorite;
use Symfony\Component\HttpFoundation\Request;
/**
*
*/
class UserControllerTest extends WebTestCase
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


  /* test l'inscription d'un utilisateur */
  public function testRegistration()
  {
    $user= new User();
    $expected['user'] = count($this->em->getRepository('FreetimeAdvisorBundle:User')->findAll()) + 1;
    /* Setters */
    $user->setUsername('fred424');
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

    // le test passe si les valeur sont égales
    $this->assertEquals($expected, $actual);

    // suppression en bdd - permet de relancer le test sans échec
    $this->em->remove($user);
    $this->em->flush();


  }

  /* test la modification d'un profil utilisateur */
  public function testEditProfile()
  {
    // recherche l'utilisateur à modifier
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    // email de l'utilisateur avant modification
    $actualUserMail = $user->getEmail();
    // modification de l'email de l'utilisateur
    $editUser = $user;
    $editUser
    ->setEmail('user974@mail.com');
    // modification en bdd
    $this->em->persist($editUser);
    $this->em->flush();
    $editUserMail = $editUser->getEmail();

    // le test passe si les valeurs comparés ne sont pas égales
    $this->assertNotEquals($editUserMail, $actualUserMail);

    // remet les infos d'origine avant modif - permet de relancer le test sans échec
    $editUser
    ->setEmail($actualUserMail);
    $this->em->persist($editUser);
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

  /* test la sélection de la liste de loisirs d'un utilisateur */
  public function testSelectHobbies()
  {
    // instancie une nouvelle liste de loisirs
    $hobbiesList = new hobbiesList();
    // compte les listes en bdd et s'attend à avoir un favoris en +
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findAll()) + 1;
    /* Setters */
    $hobbiesList->setFirst($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'NATURE')));
    $hobbiesList->setSecond($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'DIVERTISSEMENT')));
    $hobbiesList->setThird($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'RESTAURATION')));
    $hobbiesList->setUpdatedAt(new \DateTime('now'));
    $hobbiesList->SetUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    // ajoute la liste de loisirs en bdd
    $this->em->persist($hobbiesList);
    $this->em->flush();

    // compte les liste de loisirs après ajout en bdd
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }

  /* test la modification de la liste de loisirs d'un utilisateur */
  public function testEditHobbies()
  {
    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    // recherche la liste de loisirs à modifier
    $hobbiesList = $this->em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneBy(array('user'=>$user));
    // date avant modification
    $actualHobbiesListDate = $hobbiesList->getUpdatedAt();
    // modification de la liste de loisirs
    $editHobbiesList = $hobbiesList;
    $editHobbiesList
    ->setFirst($this->em->getRepository('FreetimeAdvisorBundle:Category')->findOneBy(array('name'=>'SPORT')))
    ->setUpdatedAt(new \DateTime('now'));
    // modification en bdd
    $this->em->persist($editHobbiesList);
    $this->em->flush();
    // date après modification
    $editHobbiesListDate = $editHobbiesList->getUpdatedAt();

    // test passe si les valeurs comparés ne sont pas égales
    $this->assertNotEquals($editHobbiesListDate, $actualHobbiesListDate);
    // suppression en bdd - permet de relancer le test sans erreur
    $this->em->remove($hobbiesList);
    $this->em->flush();


  }

  /* test l'ajout d'un lieu favoris en tant qu'utilisateur */
  public function testNewFavorite()
  {
    // compte les favoris en bdd et s'attend à avoir un favoris en +
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Favorite')->findAll()) + 1;

    // instancie un favoris
    $favorite = new Favorite();
    /* Setters */
    $favorite->SetUser($this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974')));
    $favorite->setPlace($this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CINEPALMES')));
    $favorite->setCreatedAt(new \DateTime('now'));
    // ajoute un favoris en bdd
    $this->em->persist($favorite);
    $this->em->flush();
    // compte les favoris après l'ajout en bdd
    $actual = count($this->em->getRepository('FreetimeAdvisorBundle:Favorite')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }


  /* test la suppression d'un lieu favoris en tant qu'utilisateur */
  public function testDeleteFavorite()
  {
    // compte les favoris en bdd et s'attend à avoir un favoris en -
    $expected = count($this->em->getRepository('FreetimeAdvisorBundle:Favorite')->findAll()) - 1;

    $user = $this->em->getRepository('FreetimeAdvisorBundle:User')->findOneBy(array('username'=>'user974'));
    $place = $this->em->getRepository('FreetimeAdvisorBundle:Place')->findOneBy(array('name'=>'CINEPALMES'));
    // recherche du favoris à supprimer
    $favorite = $this->em->getRepository('FreetimeAdvisorBundle:Favorite')->findOneBy(array('user'=>$user,'place'=>$place));

    // suppression du favoris en bdd
    $this->em->remove($favorite);
    $this->em->flush();

    // compte les favoris après la suppression en bdd
    $actual =count($this->em->getRepository('FreetimeAdvisorBundle:Favorite')->findAll());

    // test passe si les valeurs comparés sont égales
    $this->assertEquals($expected, $actual);
  }

  public function tearDown()
  {
    parent::tearDown();
    $this->em->close();
    $this->em = null;
  }
}
