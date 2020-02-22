<?php

namespace FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\PaginatorBundle\Pagination;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository('FirstBundle:Users')->findAll();


        return $this->render('FirstBundle:Default:index.html.twig',array('photos' => $photos));
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {

        return $this->render('FirstBundle:Default:about.html.twig',array());
    }

}
