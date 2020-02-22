<?php

namespace FirstBundle\Controller;
use FirstBundle\Entity\Posts;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use FirstBundle\Controller\LoginController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use PHPUnit\DbUnit\Operation\Delete;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class GalleryController extends Controller
{

    /**
     * @Route("/gallery", name="gallery")
     */
    public function galleryAction(Request $request, SessionInterface $session = null)

    {
        if ($ses = $session->get('username')) {
            $sesId = $session->get('id');

            $em = $this->getDoctrine()->getManager();
            $photos = $em->getRepository('FirstBundle:Users')->findById($sesId);

            return $this->render("FirstBundle:Gallery:gallery.html.twig", array('photos' => $photos));

        }else{
            return $this->redirect('/');
        }
    }

    /**
     *@Route("/post", name="post",methods={"POST","GET"})
     */
    public function postAction(Request $request,SessionInterface $session = null )
    {
        if ($ses = $session->get('username')) {



            $place = trim($request->request->get('place'));
            $text= trim($request->request->get('text'));

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->files->get('filetoupload');

        if (!empty($uploadedFile)) {
            $destination = $this->getParameter('upload_directory');
            $ses = $session->get('username');
            $fs= new Filesystem();
            $fs->mkdir($destination."/".$ses);
            $a = $destination."/".$ses;
            $extension = $uploadedFile->guessExtension();
            $fileName =  $place . "_" . uniqid() . '.' . $extension;
            $uploadedFile->move($a, $fileName);
            $message = "Your post was successfully uploaded!";

            if(!empty(trim($place)) && !empty(trim($text))) {
                $sesId = $session->get('id');
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('FirstBundle:Users')->findOneById($sesId);

                $post = new Posts();
                $post->setFilename($fileName);
                $post->setPlace($place);
                $post->setDescription($text);
                $post->setUser($user);



                $em->persist($post);
                $em->flush();


                return $this->redirect('/gallery');
            }else{
                $message = "You need to complete all the fields";
                return $this->render('FirstBundle:Gallery:post.html.twig', array('message'=>$message));
            }
        }


        }else{
            return $this->redirect('/');
        }

        return $this->render('FirstBundle:Gallery:post.html.twig', array());
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"POST","GET"})
     */
    public function editAction( Request $request, SessionInterface $session = null, int $id)
    {

        if ($ses = $session->get('username')) {

            $place = trim($request->request->get('place'));
            $text = trim($request->request->get('text'));

            if (!empty(trim($place)) && !empty(trim($text))) {


                $em = $this->getDoctrine()->getManager();
                $post = $em->getRepository(
                    'FirstBundle:Posts')->find($id);
                $post->setPlace($place);
                $post->setDescription($text);
                $em->flush();
                return $this->redirect("/gallery");
                }

            return $this->render('FirstBundle:Gallery:edit.html.twig', array());
        }else {
            return $this->redirect("/");
        }
    }

    /**
     * @Route("/dell/delete/{id}", name="post_delete",methods={"DELETE"})
     *
     */
    public function dellAction(Request $request, SessionInterface $session = null,int $id)
    {
        if ($ses = $session->get('username')) {

            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('FirstBundle:Posts');

            $post = $repo->find($id);


                $em->remove($post);
                $em->flush();
                $message = "Your item was deleted!";
                return $this->render('FirstBundle:Gallery:gallery.html.twig', ['message'=>$message]);
        }else{
            return $this->redirect('/');
        }

    }
}