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
        // si l'utilisateur est connecté
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // redirection sur acceuil utilisateur
            return $this->redirectToRoute('user_home');
        }

        return $this->render('@FreetimeAdvisorBundle/Resources/views/default/index.html.twig', array());


    }
}
