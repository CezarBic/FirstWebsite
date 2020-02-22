<?php
namespace FirstBundle\Controller;

use FirstBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FirstBundle\Controller\GalleryController;


class LoginController extends Controller{


    /**
     * @Route("/login", name="login",methods={"POST","GET"})
     * @Template("FirstBundle:Users:login.html.twig")
     *
     */
    public function loginAction(Request $request = null, SessionInterface $session = null)
    {   $ses = "";
        $u = isset($_POST['username']) ? $_POST['username'] : null;
        $p= isset($_POST['password'] ) ? $_POST['password'] : null;

        if(isset($_POST['submit'])){

            if(!empty(trim($u)) && !empty(trim($p))){

                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('FirstBundle:Users');

                $u = $repository->findOneBy(['username'=>$u]);

                if($u !== null && password_verify($p,$u->getPassword())){
                    $sesId = $session->set('id',$u->getId());
                    $ses = $session->set('username',$u->getUsername());

                    $message = "You are now logged in!";

                    return $this->redirect('/gallery');
                }else{
                    $message = "Wrong username or password!";
                    return $this->render("FirstBundle:Users:login.html.twig", (['message'=>$message]));
                }
            }else{
                $message = "Username and password are require";
                return $this->render("FirstBundle:Users:login.html.twig", (['message'=>$message]));
            }
        }

        return $this->render("FirstBundle:Users:login.html.twig", array());

    }
}