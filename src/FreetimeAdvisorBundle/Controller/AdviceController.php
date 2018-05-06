<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\Photo;

class AdviceController extends Controller
{
  /**
  * AJOUTE UN AVIS POUR UN LIEU
  *
  * @Route("place/{name}/new/advice", name="new_advice")
  * @Method({"GET","POST"})
  */
  public function newAdvice(Place $place, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();
    $user->getId();
    // si l'utilisateur a déjà posté un avis
    $adviceExist = $em->getRepository('FreetimeAdvisorBundle:Advice')->findby(array('user'=>$user,'place'=>$place));
    if ($adviceExist) {
      return $this->redirectToRoute('show_place', array('name' => $place->getName()));
    }
    //
    $advice = new Advice();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $form->handleRequest($request);
    $advice
    ->setUser($user)
    ->setCreatedAt("now")
    ->setPlace($place);
    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($advice);
      $em->flush();

      return $this->redirectToRoute('new_photo_advice', array('place_name' => $place->getName(),'advice_id' => $advice->getId()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/new.html.twig', array(
      'place'=> $place,
      'advice' => $advice,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }

  /**
  * MODIFIER UN AVIS
  *
  * @Route("place/{name}/advice/{id}/edit", name="edit_advice")
  * @Method({"GET","POST"})
  *
  * vérifie si c'est bien l'auteur qui modifie *
  * @Security("user.getUsername() == advice.getUser()")
  */
  public function editAdvice(Advice $advice, Request $request)
  {
    $place = $request->attributes->get('name'); //réccupère le nom du lieu dans l'url
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $advice->setUpdatedAt("now"); //date de création
      $em->persist($advice);
      $em->flush();

      return $this->redirectToRoute('show_place', array('name' => $place));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/edit.html.twig', array(
      'advice' => $advice,
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
  * SUPPRIMER UN AVIS
  *
  * @Route("place/{name}/advice/{id}/delete", name="delete_advice")
  * @Method({"GET", "DELETE"})
  *
  * vérifie si c'est bien l'auteur qui supprime *
  * @Security("user.getUsername() == advice.getUser()")
  */
  public function deleteAdvice(Advice $advice,Request $request)
  {
    $adviceId = $advice->getId(); //réccupère l'id de l'avis dans l'url
    $placeId = $advice->getPlace(); //réccupère le nom du lieu dans l'url
    $em = $this->getDoctrine()->getManager(); // instancie l'entity manager
    //recherche les photos
    $photos = $em->getRepository('FreetimeAdvisorBundle:Photo')->findBy(array('advice'=>$adviceId,'place' => $placeId));
    // si pas de photo pour cet avis
    if (!empty($photos)) {
      foreach ($photos as $photo) {
        $em->remove($photo);//supprime les photos
      }
    }
    $em->remove($advice);//supprime l'avis
    $em->flush();
    return $this->redirectToRoute('user_dashboard'); //redirection vers tableau de bord

  }

  /**
  * AJOUT DE PHOTO POUR UN AVIS
  *
  * @Route("place/{place_name}/advice/{advice_id}/new/photo", name="new_photo_advice")
  * @Template()
  * @ParamConverter("place", class="FreetimeAdvisorBundle:Place",options={"mapping":{"place_name":"name"}})
  * @ParamConverter("advice", class="FreetimeAdvisorBundle:Advice",options={"mapping":{"advice_id":"id"}})
  */
  public function newPhoto( $place, $advice, Request $request)
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
    ->setCreatedAt("now")
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
