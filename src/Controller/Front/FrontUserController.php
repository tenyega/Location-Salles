<?php

namespace App\Controller\Front;

use App\Controller\Back\BackLoginController;
use App\Entity\BackUser;
use App\Entity\FrontUser;
use App\Entity\Hall;
use App\Form\FrontUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FrontUserController extends AbstractController
{
    /**
     * @Route("/", name="front_user")
     */
    public function index(): Response
    {
        /**
         * This three functions are called to unset the session in case the admin redirects from the admin 
         * interface to the site and gets back to the admin page. he needs to reenter the credentials to secure the page.
         */
        session_start();
        session_unset();
        session_destroy();
    
        $repository=$this->getDoctrine()->getRepository(Hall ::class);
        $halls= $repository->findAll();

        return $this->render('front/front_user/index.html.twig', [
            'halls'=> $halls,
        ]);
    }
    
     /**
     * @Route("/inscription", name="front_user_inscription")
     * This function is used for the inscription of the user in which the user details are taken ones the form is submitted and valid
     * then the password is hashed using the passwordhasher of the UserPasswordHasherInterface component of the symfony
     * then the setpassword() is used to set the password 
     * then the setRoles() is used to give a ROLE_USER to the every user of the front end
     */
    public function inscription(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {              
        $user= new FrontUser;
        $form = $this->createForm(FrontUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword(),
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(["ROLE_USER"]);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('front_user_confirmation');
        }
        return $this->render('front/front_user/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation", name="front_user_confirmation")
    */
    public function confirmation()
    {
        return $this->render('front/front_user/confirmation.html.twig');
    }

   
}
