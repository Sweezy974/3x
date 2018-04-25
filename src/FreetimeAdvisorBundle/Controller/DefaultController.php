<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      //réccupère les 3 derniers lieux
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array(),array('createdAt' => 'desc'),3);
      //réccupère la moyenne des avis de chaque lieux
      $placesAvgScore = $em->getRepository('FreetimeAdvisorBundle:Advice')->allPlaceAverageScore();
      return $this->render('@FreetimeAdvisorBundle/Resources/views/default/index.html.twig', array(
        'places' => $places,
        'placeAvgScore'=>$placesAvgScore,
      ));
    }
}
