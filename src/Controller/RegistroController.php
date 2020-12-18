<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registrarse", name="registrarse")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordEncoder->encodePassword($user, $form['password']->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito', user::REGISTRO_EXITOSO);
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('registro/index.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
    public function helloAction($name)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
    
        // Old way:
        // if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        //     throw $this->createAccessDeniedException('Unable to access this page!');
        // }
    
        // ...
    }
}	

