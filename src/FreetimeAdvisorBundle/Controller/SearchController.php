<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SearchController extends Controller
{
  // /**
  // * @Route("search/place/by/category/{category_name}", name="searchPlaceByCategory")
  // * @Template()
  // * @ParamConverter("category", class="FreetimeAdvisorBundle:Category",options={"mapping":{"category_name":"name"}})
  // */
  // public function searchPlaceByCategory($category)
  // {
  //   $category->getName();
  //   $em = $this->getDoctrine()->getManager();
  //   $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('category'=>$category),array('id' => 'desc'));
  //   return $this->render('@FreetimeAdvisorBundle/Resources/views/place/search/category/index.html.twig', array(
  //     'places' => $places,
  //   ));
  // }
}
