<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use FreetimeAdvisorBundle\Entity\Hobbies;
use FreetimeAdvisorBundle\Entity\Favorites;
use FreetimeAdvisorBundle\Entity\Place;

class UserController extends Controller
{
  /**
  * @Route("user/dashboard", name="user_dashboard")
  */
  public function dashboard()
  {
    $user = $this->getUser();
    $user->getId();
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('user'=>$user),array('id' => 'desc'));
    $advices = $em->getRepository('FreetimeAdvisorBundle:Advice')->findby(array('user'=>$user),array('id' => 'desc'));
    $hobbies = $em->getRepository('FreetimeAdvisorBundle:Hobbies')->findOneByUser(array('user'=>$user));
    $favorites = $em->getRepository('FreetimeAdvisorBundle:Favorites')->findby(array('userId'=>$user),array('id' => 'desc'));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/dashboard/index.html.twig', array(
      'places' => $places,
      'advices' => $advices,
      'hobbies' => $hobbies,
      'favorites' => $favorites,
    ));
  }

  /**
  * @Route("/user/hobbies/select", name="user_select_hobbies")
  * @Method({"GET","POST"})
  */
  public function selectHobbies(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $hobbies = new Hobbies();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\HobbiesType', $hobbies);
    $form->handleRequest($request);
    $hobbies->setUser($user);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($hobbies);
      $em->flush();

      return $this->redirectToRoute('user_dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/hobbies/new.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
  * @Route("user/{pseudo}/hobbies/{id}/edit", name="user_edit_hobbies")
  * @Method({"GET","POST"})
  */
  public function editHobbies(Hobbies $hobbies ,Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\HobbiesType', $hobbies);
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
      $favorites = $em->findBy(array('userId' => $user ,'placeId' => $place));
      if ($favorites) {
        return $this->redirectToRoute('user_dashboard', array('id' => $place->getId()));
      }
      else {
        $favorites = new Favorites();
        $favorites
        ->setUserId($user)
        ->setPlaceId($place);
        $em = $this->getDoctrine()->getManager();
        $em->persist($favorites);
        $em->flush();
        return $this->redirectToRoute('user_dashboard');
      }
    }
    return $this->redirectToRoute('fos_user_security_login');
  }

  /**
  * delete a favorite place
  *
  * @Route("user/favorites/{id}/delete", name="delete_favorite")
  * @Method({"GET", "DELETE"})
  */
  public function deleteFavorite(Favorites $favorites)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($favorites);
    $em->flush();
    return $this->redirectToRoute('user_dashboard');
  }
}
