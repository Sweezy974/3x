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
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/dashboard/index.html.twig', array(
      // 'place' => $place,
      // 'user' => $user,
      // 'form' => $form->createView(),
    ));
  }
}
