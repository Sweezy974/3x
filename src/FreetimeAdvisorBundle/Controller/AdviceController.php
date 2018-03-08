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
  * @Route("/new/advice", name="new_advice")
  * @Method("GET")
  */
  public function newAdvice(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $advice = new Advice();
    $form = $this->createForm('FreetimeAdvisorBundle\Form\AdviceType', $advice);
    $form->handleRequest($request);
    // $em = $this->getDoctrine()->getManager();
    // $advice = $em->getRepository('FreetimeAdvisorBundle:Category')->findAll();
    // return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/new.html.twig', array(
    //     'advice' => $advice,
    // ));
    return $this->render('@FreetimeAdvisorBundle/Resources/views/advice/new.html.twig', array(
      'advice' => $advice,
      'user' => $user,
      'form' => $form->createView(),
    ));
  }
  public function newAction(Request $request)
  {
    $user = $this->getUser();
    $user->getId();
    $article = new Article();
    $form = $this->createForm('Blog\RunBlogBundle\Form\ArticleType', $article);
    $form->handleRequest($request);
    $article->setDate(date("d-m-Y"))
    ->setUtilisateur($user);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($article);
      $em->flush();

      return $this->redirectToRoute('article_show', array('id' => $article->getId()));
    }

    return $this->render('article/new.html.twig', array(
      'article' => $article,
      'form' => $form->createView(),
    ));
  }
}
