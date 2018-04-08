<?php

namespace FreetimeAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchController extends Controller
{
  /**
  * Génère un form pour la recherche de lieu
  */
  public function searchPlaceAction()
  {
    $form = $this->createFormBuilder(null)
    ->add('city', EntityType::class, array(
      'label'=>'Ville *',
      'mapped'=>true,
      'class' => 'FreetimeAdvisorBundle:City',
      'choice_label' => 'name',
      'attr' => ['class'=>''],
      'multiple'=>'true'
    ))
    ->add('category', EntityType::class, array(
      'label'=>'Catégorie *',
      'mapped'=>true,
      'class' => 'FreetimeAdvisorBundle:Category',
      'multiple' => 'true',
      'choice_label' => 'name',
      'attr' => ['class'=>''],

    ))
    ->add('name', TextType::class, array('label'=>'Nom du lieu','required' => false,'attr' => array('class' => 'autocomplete','placeholder'=>'entrez le lieu recherché (facultatif)')))
    ->add('save', SubmitType::class, array('label' => 'rechercher','attr' => array('class' => 'submit')))
    ->getForm();

    return $this->render('::searchbar.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
  * @Route("place/search/", name="searchPlace")
  * @param Request $request
  */
  public function searchPlaceResult(Request $request)
  {
    $city=$request->get("form")["city"] ;
    $category=$request->get("form")["category"] ;
    $name=$request->get("form")["name"] ;
    $em = $this->getDoctrine()->getManager();

    if (empty($name)) {
      // si le nom n'est pas spécifié
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('category'=>$category,'city' => $city));
    }
    elseif (empty($city)) {
      // si la ville n'est pas spécifié
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('category'=>$category,'name' => $name));
    }
    elseif (empty($category)) {
      // si la catégorie n'est pas spécifié
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('city' => $city,'name' => $name));
    }
    else {
      // si le nom, la catégorie et la ville est spécifié
      $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('category'=>$category,'city' => $city,'name' => $name));
    }
    // réccupère la moyenne des avis pour chaque lieu
    $placesAvgScore = $em->getRepository('FreetimeAdvisorBundle:Advice')->allPlaceAverageScore();
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/search/result.html.twig', array(
      'places' => $places,
      'placeAvgScore'=>$placesAvgScore
    ));
  }

  /**
  * @Route("place/by/category/{category_name}", name="searchPlaceByCategory")
  * @Template()
  * @ParamConverter("category", class="FreetimeAdvisorBundle:Category",options={"mapping":{"category_name":"name"}})
  */
  public function searchPlaceByCategory($category)
  {
    $category->getName();
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('category'=>$category),array('id' => 'desc'));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/search/result.html.twig', array(
      'places' => $places,
    ));
  }

  /**
  * @Route("place/by/city/{city_name}", name="searchPlaceByCity")
  * @Template()
  * @ParamConverter("city", class="FreetimeAdvisorBundle:City",options={"mapping":{"city_name":"name"}})
  */
  public function searchPlaceByCity($city)
  {
    $city->getName();
    $em = $this->getDoctrine()->getManager();
    $places = $em->getRepository('FreetimeAdvisorBundle:Place')->findby(array('city'=>$city),array('id' => 'desc'));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/place/search/result.html.twig', array(
      'places' => $places,
    ));
  }

  /**
  * @Route("discover", name="discover_place")
  * redirige vers un lieu
  */
  public function searchRandomPlace()
  {
    $em = $this->getDoctrine()->getManager();
    $randomPlace = $em->getRepository('FreetimeAdvisorBundle:Place')->randomPlace();
    // var_dump($randomPlace);
    $placeName = $randomPlace->getName();
    return $this->redirectToRoute('show_place', array('name' => $placeName));
  }
}
