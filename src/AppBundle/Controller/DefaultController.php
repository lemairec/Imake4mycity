<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\User;


use AppBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        //return $this->render('default/index.html.twig', [
        //    'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        //]);

        return $this->render('AppBundle:Default:home.html.twig');
    }

    
    public function loginAction()
    {
        //Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('home');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');
        return $this->render('AppBundle:Default:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/user/{user_id}", name="user")
     **/
    public function userEditAction($user_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($user_id == '0'){
            $user = new User();
        } else {
            $user = $em->getRepository('AppBundle:User')->findOneById($user_id);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $em->persist($campagne);
            $em->flush();
            return $this->redirectToRoute('campagnes');
        }
        return $this->render('AppBundle::base_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
