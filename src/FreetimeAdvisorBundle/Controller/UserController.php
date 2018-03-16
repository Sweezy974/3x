<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
