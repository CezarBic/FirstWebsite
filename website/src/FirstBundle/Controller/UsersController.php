<?php
namespace FirstBundle\Controller;

use FirstBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class UsersController extends Controller
{
    /**
     * @Route("/create", name="create",methods={"POST","GET"})
     * @Template("FirstBundle:Users:create.html.twig")
     *
     */
    public function createAction()
    {
        $n = isset($_POST['name']) ? $_POST['name']: null;
        $u = isset($_POST['username']) ? $_POST['username'] : null;
        $s = isset($_POST['surname']) ? $_POST['surname'] : null;
        $e = isset($_POST['email']) ? $_POST['email'] : null;
        $p = isset($_POST['password']) ? $_POST['password'] : null;
        $pc = isset($_POST['cpassword']) ? $_POST['cpassword'] : null;
        if (isset($_POST['submit'])) {
            if (!empty(trim($n)) && !empty(trim($s)) && !empty(trim($e))
                && !empty(trim($p)) && !empty(trim($u)) && !empty(trim($pc))) {
                    //allows only characters from a-z A-Z 0-9
                $a = preg_replace("/([^a-zA-Z0-9])/", "", $n);
                $b = preg_replace("/([^a-zA-Z0-9])/", "", $s);
                $z = preg_replace("/([^a-zA-Z0-9])/", "", $u);

                if(filter_var($e, FILTER_VALIDATE_EMAIL)){
                    $c =filter_var($e, FILTER_VALIDATE_EMAIL);
                    $f = preg_replace("/([^a-zA-Z0-9])/", "", $p);
                    if($f == $pc){
                        if(preg_match("/(?=.*[a-z]+)(?=.*[A-Z]+)(?=.*\d)[a-zA-Z\d]{8,}/", $f)) {

                            $ph = password_hash($f, PASSWORD_DEFAULT);

                            $user = new Users();
                            $user->setName($a);
                            $user->setSurname($b);
                            $user->setUsername($z);
                            $user->setEmail($c);
                            $user->setPassword($ph);

                            $em = $this->getDoctrine()->getManager();
                            $repository = $em->getRepository('FirstBundle:Users');

                            $post = $repository->findOneBy(['username'=>$z]);
                            $epost = $repository->findOneBy(['email'=>$c]);
                            if($post){
                                $message = "Username is taken!";
                                return $this->render("FirstBundle:Users:create.html.twig", (['message'=>$message]));
                            }elseif($epost) {
                                $message = "E-mail is taken!";
                                return $this->render("FirstBundle:Users:create.html.twig", (['message' => $message]));
                            }else{

                            $em->persist($user);
                                $em->flush();
                                $message = "Your registration is complete! You can now login";
                                return $this->render("FirstBundle:Users:login.html.twig", (['message'=>$message]));

                            }

                        }else{

                            $message = "Your password must be 8 characters long and to contain 'A','a','1'.";
                            return $this->render("FirstBundle:Users:create.html.twig", (['message'=>$message]));

                        }

                    }else{

                        $message = "Password don`t match!";
                        return $this->render("FirstBundle:Users:create.html.twig", (['message'=>$message]));

                    }
                }else{
                    $message = "Your email is not valid!";
                    return $this->render("FirstBundle:Users:create.html.twig", (['message'=>$message]));

                }
            } else {
                $message = "Please complete all the fields!";
                return $this->render("FirstBundle:Users:create.html.twig", (['message'=>$message]));

            }
        }

        return $this->render("FirstBundle:Users:create.html.twig", array());
    }

}