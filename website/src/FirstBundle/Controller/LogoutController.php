<?php

namespace FirstBundle\Controller;

use FirstBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class LogoutController extends Controller
{
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(SessionInterface $session)
    {
        $session->remove('username');


        return $this->redirect("/");

    }
}