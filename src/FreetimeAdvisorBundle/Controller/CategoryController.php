<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FreetimeAdvisorBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CategoryController extends Controller
{
  /**
  * @Route("/register/categories", name="register_categories")
  * @Method("GET")
   */
  public function registerFavoriteCategories()
  {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('FreetimeAdvisorBundle:Category')->findAll();
    return $this->render('@FreetimeAdvisorBundle/Resources/views/user/categories.html.twig', array(
        'categories' => $categories,
    ));
  }
}
