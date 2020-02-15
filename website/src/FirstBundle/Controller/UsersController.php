<?php
namespace FirstBundle\Controller;

use FirstBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/user")
 *
 */
class UsersController extends Controller
{
    /**
     * @Route("/create", name="create",methods={"POST","GET"})
     * @Template("FirstBundle:Users:create.html.twig")
     *
     */
    public function createAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('password', PasswordType::class)
            ->add('cpassword', PasswordType::class)
            ->add('save', SubmitType::class, ['label' => 'Add User'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $n = $form['name']->getData();
            $u = $form['username']->getData();
            $s = $form['surname']->getData();
            $e = $form['email']->getData();
            $p = $form['password']->getData();
            $pc = $form['cpassword']->getData();
            if (!empty(trim($n)) && !empty(trim($s)) && !empty(trim($e))
                && !empty(trim($p)) && !empty(trim($u)) && !empty(trim($pc))) {
                    //allows only characters from a-z A-Z 0-9
                $a = preg_replace("/([^a-zA-Z0-9])/", "", $n);
                $b = preg_replace("/([^a-zA-Z0-9])/", "", $s);
                $z = preg_replace("/([^a-zA-Z0-9])/", "", $u);

                if(filter_var($e, FILTER_VALIDATE_EMAIL)){
                    $c =filter_var($e, FILTER_VALIDATE_EMAIL);//validates email
                    $f = preg_replace("/([^a-zA-Z0-9])/", "", $p);
                    if($f == $pc){ //check if passwords match
                        if($g = preg_match("/(?=.*[a-z]+)(?=.*[A-Z]+)(?=.*\d)[a-zA-Z\d]{8,}/", $f)) {
                            $ph = password_hash($g, PASSWORD_DEFAULT);//encripts the password
                            $user = new Users();
                            $user->setName($a);
                            $user->setSurname($b);
                            $user->setUsername($z);
                            $user->setEmail($c);
                            $user->setPassword($ph);

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($user);
                            $em->flush();

                           return $this->redirect("/user/create");
                        }else{
                            echo "Your password must be 8 characters long and contain 'A','a','1'";
                        }

                    }else{
                        echo "Password don`t match!";
                    }
                }else{
                    echo "Your email is not valid!";
                }
            } else {
                echo "Please complete all the fields!";
            }
        }
        return $this->render("FirstBundle:Users:create.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/show", name="show")
     * @Template("FirstBundle:Users:show.html.twig")
     **/
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FirstBundle:Users')->findAll();

        return $this->render("FirstBundle:Users:show.html.twig",array('repository'=>$repository));

    }
}