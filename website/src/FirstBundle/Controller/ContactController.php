<?php

namespace FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\MonologBundle\SwiftMailer;


class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact",methods={"GET"})
     */
    public function contactShowAction(Request $request, \Swift_Mailer  $mailer)
    {
        return $this->render('FirstBundle:Users:contact.html.twig',array());
    }

    /**
     * @Route("/contact", name="contact_post",methods={"POST"})
     */
    public function contactAction(Request $request, \Swift_Mailer  $mailer)
    {

        $subject = $request->request->get('subject');
        $email = $request->request->get('email');
        $text = $request->request->get('text');
    if(!empty($email) && !empty($subject) && !empty($text)) {
        $message = (new \Swift_Message($subject))
            ->setFrom($email)
            ->setTo('bican.cezar@gmail.com')
            ->setBody($text);
            $mailer->send($message);
            $msg = "E-mail sent!";
            return $this->render('FirstBundle:Users:contact.html.twig', ['msg'=>$msg]);

        }else{
        $msg = "You need to complete all the fields!";
        return $this->render('FirstBundle:Users:contact.html.twig', ['msg'=>$msg]);
    }

    }

}
