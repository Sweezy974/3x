<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use FreetimeAdvisorBundle\Entity\Hobbies;

class UserController extends Controller
{
  /**
  * @Route("/dashboard", name="dashboard")
  */
  public function dashboard()
  {
    $user = $this->getUser();
    $user->getId();
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('user'=>$user),array('id' => 'desc'));
    $advices = $em->getRepository('FreetimeAdvisorBundle:Advice')->findby(array('user'=>$user),array('id' => 'desc'));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/dashboard/index.html.twig', array(
      'places' => $places,
      'advices' => $advices
    ));
  }

  /**
  * @Route("/user/hobbies/select", name="new_place")
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

      return $this->redirectToRoute('dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/hobbies/new.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
  * @Route("user/{pseudo}/hobbies/{id}/edit", name="edit_hobbies")
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

      return $this->redirectToRoute('dashboard');
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/hobbies/edit.html.twig', array(
      'hobbies' => $hobbies,
      'edit_form' => $editForm->createView(),
    ));
  }
}
