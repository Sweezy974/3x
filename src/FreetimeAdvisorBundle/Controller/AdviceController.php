<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FreetimeAdvisorBundle\Entity\Advice;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class AdviceController extends Controller
{
  /**
  * @Route("place/{idPlace}/advice/{id}/edit", name="edit_advice")
  * @Method({"GET","POST"})
  */
  public function editAdvice(Advice $advice, Request $request)
  {
    $place = $request->attributes->get('idPlace');
    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $advice->setDate("now");
      $em->persist($advice);
      $em->flush();

      return $this->redirectToRoute('show_place', array('id' => $place));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/edit.html.twig', array(
      'advice' => $advice,
      'edit_form' => $editForm->createView(),
    ));
  }
}
