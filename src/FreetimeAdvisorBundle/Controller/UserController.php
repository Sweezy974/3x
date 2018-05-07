<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use FreetimeAdvisorBundle\Entity\HobbiesList;
use FreetimeAdvisorBundle\Entity\Favorite;
use FreetimeAdvisorBundle\Entity\Place;


class UserController extends Controller
{
  /**
  * ACCUEIL UTILISATEUR
  *
  * @Route("home",name="user_home")
  */
  public function index()
  {
      $user = $this->getUser();
      $user->getId();
      $em = $this->getDoctrine()->getManager();
      // réccupère les 3 derniers lieux
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array(),array('createdAt' => 'desc'),3);
      // cherche la liste de l'utilisateur
      $hobbies = $em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneByUser(array('user'=>$user));
      // stocke les 3 catégories dans un tableau
      $hobbiesList = array($hobbies->getFirst(),$hobbies->getSecond(),$hobbies->getThird());
      // réccupère 3 lieux correspondant à la liste de loisir de l'utilisateur
      $hobbiesPlaces = $em->getRepository('FreetimeAdvisorBundle:Place')->findBy(array('category' => $hobbiesList),array(),3);
      // réccupère 3 lieux se trouvant dans la même zone de l'utilisateur
      $userArea = $user->getCity()->getArea();
      $cityInArea = $em->getRepository('FreetimeAdvisorBundle:City')->findBy(array('area' => $userArea));
      $areaPlaces = $em->getRepository('FreetimeAdvisorBundle:Place')->findBy(array('city' => $cityInArea),array(),3);

      //réccupère la moyenne des avis de chaque lieux
      $placesAvgScore = $em->getRepository('FreetimeAdvisorBundle:Advice')->allPlaceAverageScore();
      return $this->render('@FreetimeAdvisorBundle/Resources/views/default/index.html.twig', array(
          'places' => $places,
          'placeAvgScore'=>$placesAvgScore,
          'hobbiesPlaces'=>$hobbiesPlaces,
          'areaPlaces'=>$areaPlaces
      ));
  }

  /**
  * PAGE TABLEAU DE BORD UTILISATEUR
  *
  * @Route("user/dashboard", name="user_dashboard")
  */
  public function dashboard()
  {
    $user = $this->getUser();
    $user->getId();
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('user'=>$user),array('id' => 'desc'));
    $advices = $em->getRepository('FreetimeAdvisorBundle:Advice')->findby(array('user'=>$user),array('id' => 'desc'));
    $hobbies = $em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneByUser(array('user'=>$user));
    $favorites = $em->getRepository('FreetimeAdvisorBundle:Favorite')->findby(array('user'=>$user),array('id' => 'desc'));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/dashboard/index.html.twig', array(
      'places' => $places,
      'advices' => $advices,
      'hobbies' => $hobbies,
      'favorites' => $favorites,
    ));
  }

  /**
  * CHOIX DES LOISIRS PREFERES D'UN UTILISATEUR
  *
  * @Route("/user/hobbies/select", name="user_select_hobbies")
  * @Method({"GET","POST"})
  */
  public function selectHobbies(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $em = $this->getDoctrine()->getManager();
    // vérifie si l'utilisateur a déjà séléctionné ses loisirs préférés
    $hobbiesExist = $em->getRepository('FreetimeAdvisorBundle:HobbiesList')->findOneByUser(array('user'=>$user));
    if ($hobbiesExist) {
      return $this->redirectToRoute('user_dashboard');
    }
    //
    $hobbies = new HobbiesList();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\HobbiesListType', $hobbies);
    $form->handleRequest($request);
    $hobbies->setUser($user)
    ->setUpdatedAt("now");
    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($hobbies);
      $em->flush();

      return $this->redirectToRoute('user_dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/hobbies/new.html.twig', array(
      'form' => $form->createView(),
    ));


  }

  /**
  * MODIFIE LES LOISIRS PREFERES D'UN UTILISATEUR
  *
  * @Route("user/hobbies/{id}/edit", name="user_edit_hobbies")
  * @Method({"GET","POST"})
  *
  * vérifie si c'est bien l'auteur qui modifie
  * @Security("user.getUsername() == hobbies.getUser()")
  */
  public function editHobbies(HobbiesList $hobbies ,Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\HobbiesListType', $hobbies);
    $hobbies->setUpdatedAt("now");
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($hobbies);
      $em->flush();

      return $this->redirectToRoute('user_dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/hobbies/edit.html.twig', array(
      'hobbies' => $hobbies,
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
  * AJOUTER UN LIEU EN FAVORIS
  *
  * @Route("/place/{id}/new/favorite", name="user_new_favorite")
  * @Method({"GET","POST"})
  */
  public function newFavorite(Place $place ,Request $request)
  {
    if ($this->getUser()) {
      $user = $this->getUser();
      $user->getId();
      $place->getId();
      $em = $this->getDoctrine()->getManager()->getRepository('FreetimeAdvisorBundle:Favorite');
      $favorite = $em->findBy(array('user' => $user ,'place' => $place));
      if ($favorite) {
        return $this->redirectToRoute('user_dashboard', array('id' => $place->getId()));
      }
      else {
        $favorite = new Favorite();
        $favorite
        ->setUser($user)
        ->setPlace($place)
        ->setCreatedAt("now");
        $em = $this->getDoctrine()->getManager();
        $em->persist($favorite);
        $em->flush();
        return $this->redirectToRoute('user_dashboard');
      }
    }
    return $this->redirectToRoute('fos_user_security_login');
  }

  /**
  * SUPPRIMER UN FAVORIS
  *
  * @Route("user/favorite/{id}/delete", name="delete_favorite")
  * @Method({"GET", "DELETE"})
  *
  * vérifie si c'est bien l'auteur qui supprime*
  * @Security("user.getUsername() == favorite.getUser()")
  */
  public function deleteFavorite(Favorite $favorite)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($favorite);
    $em->flush();
    return $this->redirectToRoute('user_dashboard');
  }

  /**
  * MODIFIER UN PROFIL
  *
  * @Route("user/profile/edit", name="user_profile_edit")
  * @Method({"GET","POST"})
  */
  public function editProfile(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\RegistrationType',$user);
    $editForm->remove('username');/* retire le champs username car  non modifiable*/
    $editForm->remove('plainPassword');/* retire le champs password car  non modifiable*/
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/profile/edit.html.twig', array(
      'edit_form' => $editForm->createView(),
    ));
  }
}
