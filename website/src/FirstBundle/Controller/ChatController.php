<?php
namespace FirstBundle\Controller;

use FirstBundle\Entity\Chat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ChatController
 * @package FirstBundle\Controller
 *
 * @Route("/chat")
 */
class ChatController extends Controller
{
    /**
     * @Route("/", name="chat",methods={"POST","GET"})
     *
     */
    public function chatAction(SessionInterface $session = null,Request $req)
    {   $ses = $session->get('username');
        $msg= isset($_POST['message']) ? $_POST['message'] : null;
         $a = !empty(trim($msg));
        if($ses == true) {
            if ($a == true) {

                $message = new Chat();
                $message->setMessages($msg);
                $message->setFromw($ses);
                $message->setCreated((new \DateTime('NOW')));

                $em = $this->getDoctrine()->getManager();

                $em->persist($message);
                $em->flush();
                $repository = $em->getRepository('FirstBundle:Chat')->findAll();

                return $this->render('FirstBundle:Users:chat.html.twig', ['messages' => $repository]);

            } else {
                return $this->render('FirstBundle:Users:chat.html.twig', []);
            }
        }
        return $this->redirect('/');
    }
}