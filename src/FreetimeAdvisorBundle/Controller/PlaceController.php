<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class PlaceController extends Controller
{
  /**
  *
  * @Route("/place/index", name="place_index")
  * @Method("GET")
  */
  public function index()
  {
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array(),array('date' => 'desc'),9);/*réccupère les 9 derniers lieux */
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/index.html.twig', array(
      'places' => $places,
    ));
  }

  /**
  * @Route("/new/place", name="new_place")
  * @Method({"GET","POST"})
  */
  public function newPlace(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $place = new Place();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\PlaceType', $place);
    $form->handleRequest($request);
    $place->setUser($user)
    ->setDate("now");
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($place);
      $em->flush();

      return $this->redirectToRoute('new_place_advice', array('name' => $place->getName()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/new.html.twig', array(
      'place' => $place,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }


  /**
  * @Route("place/{name}", name="show_place")
  * @Method({"GET","POST"})
  */
  public function showPlace(Place $place, Request $request)
  {
    $advice = new Advice();
    $comment = $advice->getTitle();
    $user = $this->getUser();
    $user->getId();
    $place->getId();
    $em = $this->getDoctrine()->getManager()->getRepository('FreetimeAdvisorBundle:Favorites');
    $favorites = $em->findOneBy(array('userId' => $user ,'placeId' => $place));


    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/show.html.twig', array(
      'place' => $place,
      'favorites'=>$favorites
    ));
  }

  /**
  * @Route("place/{name}/edit", name="edit_place")
  * @Method({"GET","POST"})
  *
  * vérifie si c'est bien l'auteur qui modifie*
  * @Security("user.getUsername() == place.getUser()")
  */
  public function editPlace(Place $place, Request $request)
  {

    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\PlaceType', $place);
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $place->setDate("now");
      $em->persist($place);
      $em->flush();

      return $this->redirectToRoute('show_place', array('name' => $place->getName()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/edit.html.twig', array(
      'place' => $place,
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
  * @Route("place/{name}/new/advice", name="new_place_advice")
  * @Method({"GET","POST"})
  */
  public function newPlaceAdvice(Place $place, Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $advice = new Advice();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $form->handleRequest($request);
    $advice
    ->setUser($user)
    ->setDate("now")
    ->setPlace($place);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advice);
      $em->flush();

      return $this->redirectToRoute('new_place_photo', array('place_name' => $place->getName(),'advice_id' => $advice->getId()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/new.html.twig', array(
      'place'=> $place,
      'advice' => $advice,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }

  /**
  * @Route("place/{place_name}/advice/{advice_id}/new/photo", name="new_place_photo")
  * @Template()
  * @ParamConverter("place", class="FreetimeAdvisorBundle:Place",options={"mapping":{"place_name":"name"}})
  * @ParamConverter("advice", class="FreetimeAdvisorBundle:Advice",options={"mapping":{"advice_id":"id"}})
  */
  public function newPlacePhoto( $place, $advice, Request $request)
  {
    // $advice = $this->getAdvice();
    $advice->getId();
    // dump($advice);
    $user = $this->getUser();
    $user->getId();
    $photo = new Photo();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\PhotoType', $photo);
    $form->handleRequest($request);
    $photo
    ->setUser($user)
    ->setDate("now")
    ->setAdvice($advice)
    ->setPlace($place);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($photo);
      $em->flush();

      return $this->redirectToRoute('show_place', array('name' => $place->getName()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/photo/new.html.twig', array(
      'place'=> $place,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }



}
