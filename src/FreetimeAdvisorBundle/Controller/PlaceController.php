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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FreetimeAdvisorBundle\Entity\Place;
use FreetimeAdvisorBundle\Entity\Advice;
use FreetimeAdvisorBundle\Entity\Photo;


class PlaceController extends Controller
{
  /**
  * AFFICHE LES LIEUX SUR UNE PAGE
  *
  * @Route("/place/index", name="place_index")
  * @Method("GET")
  */
  public function index()
  {
    $em = $this->getDoctrine()->getManager();
    //réccupère les 9 derniers lieux
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array(),array('createdAt' => 'desc'),9);
    //réccupère la moyenne des avis de chaque lieux
    $placesAvgScore = $em->getRepository('FreetimeAdvisorBundle:Advice')->allPlaceAverageScore();
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/index.html.twig', array(
      'places' => $places,
      'placeAvgScore'=>$placesAvgScore,
    ));
  }

  /**
  * AJOUTER UN LIEU
  *
  * @Route("/place/new", name="new_place")
  * @Method({"GET","POST"})
  */
  public function newPlace(Request $request)
  {
    $user = $this->getUser();
    $user->getId(); //réccupère l'id de l'utilisateur actuel
    $place = new Place(); //instancie le lieu
    //créé un formulaire
    $form = $this->createForm('FreetimeAdvisorBundle\Form\PlaceType', $place);
    $form->handleRequest($request);
    $place->setUser($user) //ajoute l'id du créateur
          ->setCreatedAt("now");// ajoute la date du jour
    // si le formulaire envoie les infos et est valide
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($place);//sauvegarde des données
      $em->flush(); //ajout en base
      //redirection vers la vue du lieu précédemment créé
      return $this->redirectToRoute('new_advice', array('name' => $place->getName()));
    }
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/new.html.twig', array(
      'place' => $place,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }


  /**
  * PAGE D'UN LIEU
  *
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
    $em = $this->getDoctrine()->getManager();
    // vérifie si l'utilisateur a déjà posté un avis pour le lieu
    $adviceExist = $em->getRepository('FreetimeAdvisorBundle:Advice')->findOneBy(array('user'=>$user,'place'=>$place));
    // vérifie si l'utilisateur a ajouter le lieu en favoris
    $favorites = $em->getRepository('FreetimeAdvisorBundle:Favorites')->findOneBy(array('user' => $user ,'place' => $place));
    // réccupère la moyenne des avis par rapport au lieu
    $placeAvgScore = $em->getRepository('FreetimeAdvisorBundle:Advice')->placeAverageScore($place);
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/show.html.twig', array(
      'place' => $place,
      'favorites'=>$favorites,
      'placeAvgScore'=>$placeAvgScore,
      'adviceExist'=>$adviceExist
    ));
  }

  /**
  * MODIFIER UN LIEU
  *
  * @Route("place/{name}/edit", name="edit_place")
  * @Method({"GET","POST"})
  *
  * vérifie si c'est bien l'auteur qui modifie
  * @Security("user.getUsername() == place.getUser()")
  */
  public function editPlace(Place $place, Request $request)
  {

    $editForm = $this->createForm('FreetimeAdvisorBundle\Form\PlaceType', $place);
    $editForm->handleRequest($request);
    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $place->setCreatedAt("now");
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
  * SUPPRIMER UN LIEU
  *
  * @Route("place/{name}/delete", name="delete_place")
  * @Method({"GET", "DELETE"})
  *
  * vérifie si c'est bien l'auteur qui supprime *
  * @Security("user.getUsername() == place.getUser()")
  */
  public function deletePlace(Place $place,Request $request)
  {
    $em = $this->getDoctrine()->getManager(); // instancie l'entity manager
    $em->remove($place);//supprime l'avis
    $em->flush();
    return $this->redirectToRoute('user_dashboard'); //redirection vers tableau de bord

  }


}
