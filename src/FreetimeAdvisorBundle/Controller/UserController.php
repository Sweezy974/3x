<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use FreetimeAdvisorBundle\Entity\HobbiesList;
use FreetimeAdvisorBundle\Entity\Favorites;
use FreetimeAdvisorBundle\Entity\Place;


class UserController extends Controller
{
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
    $favorites = $em->getRepository('FreetimeAdvisorBundle:Favorites')->findby(array('user'=>$user),array('id' => 'desc'));
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
      $em = $this->getDoctrine()->getManager()->getRepository('FreetimeAdvisorBundle:Favorites');
      $favorites = $em->findBy(array('user' => $user ,'place' => $place));
      if ($favorites) {
        return $this->redirectToRoute('user_dashboard', array('id' => $place->getId()));
      }
      else {
        $favorites = new Favorites();
        $favorites
        ->setUser($user)
        ->setPlace($place)
        ->setCreatedAt("now");
        $em = $this->getDoctrine()->getManager();
        $em->persist($favorites);
        $em->flush();
        return $this->redirectToRoute('user_dashboard');
      }
    }
    return $this->redirectToRoute('fos_user_security_login');
  }

  /**
  * SUPPRIMER UN FAVORIS
  *
  * @Route("user/favorites/{id}/delete", name="delete_favorite")
  * @Method({"GET", "DELETE"})
  *
  * vérifie si c'est bien l'auteur qui supprime*
  * @Security("user.getUsername() == favorites.getUser()")
  */
  public function deleteFavorite(Favorites $favorites)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($favorites);
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
