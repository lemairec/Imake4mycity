<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\User;
use AppBundle\Entity\Podometer;


use AppBundle\Form\PodometerType;

use DateTime;

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
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('AppBundle:Podometer')->sumAll();
        return $this->render('AppBundle:Default:home.html.twig', array(
            'res' => $res
        ));
    }


    /**
     * @Route("/podometers", name="podometers")
     **/
    public function podometersAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $podometers = $em->getRepository('AppBundle:Podometer')->findByUser($user);

        return $this->render('AppBundle:Default:podometers.html.twig', array(
            'podometers' => $podometers,
        ));
    }

    /**
     * @Route("/podometer/{podometer_id}", name="podometer")
     **/
    public function podometerEditAction($podometer_id, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if($podometer_id == '0'){
            $podometer = new Podometer();
            $podometer->user = $user;
            $podometer->date = new \Datetime();

        } else {
            $podometer = $em->getRepository('AppBundle:Podometer')->findOneById($podometer_id);
        }
        $form = $this->createForm(PodometerType::class, $podometer);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $em->persist($podometer);
            $em->flush();
            return $this->redirectToRoute('podometers');
        }
        return $this->render('AppBundle::base_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("api/pas", name="pas")
     **/
    public function produitNameApi(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('AppBundle:Podometer')->sumAll();

        return $this->json($res);
    }

}
