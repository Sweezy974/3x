<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class AdviceController extends Controller
{
  /**
  * @Route("place/{name}/advice/{id}/edit", name="edit_advice")
  * @Method({"GET","POST"})
  */
  public function editAdvice(Advice $advice, Request $request)
  {
    $place = $request->attributes->get('name');
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $advice->setDate("now");
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
  * delete an advices
  *
  * @Route("place/{name}/advice/{id}/delete", name="delete_advice")
  * @Method({"GET", "DELETE"})
  */
  public function deleteAdvice(Advice $advice,Request $request)
  {
    $adviceId = $advice->getId();
    $placeId = $advice->getPlace();
    $em = $this->getDoctrine()->getManager();
    $photos = $em->getRepository('FreetimeAdvisorBundle:Photo')->findBy(array('advice'=>$adviceId,'place' => $placeId));
    // si pas de photo pour cet avis
    if (!empty($photos)) {
      foreach ($photos as $photo) {
        $em->remove($photo);
      }
    }
    $em->remove($advice);
    $em->flush();
    return $this->redirectToRoute('user_dashboard');

  }
}
