<?php

namespace Imake4mycityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('Imake4mycityBundle:Default:index.html.twig');
    }
}
