<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\RegisterType;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/insert/user', name: 'createRegister')]
    public function createUser(EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $user->setUsername("admin");
        $user->setPassword($hasher->hashPassword($user, "admin"));
        $user->setName("Admin");
        $user->setRoles(["ROLE_ADMIN"]);

        $doctrine->persist($user);
        $doctrine->flush();
        return new Response("User logged in successfully");
    }

    #[Route("/new/register", name: "newRegister")]
    public function newRegister(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $register = $form->getData();
            $register->setPassword($hasher->hashPassword($register, $register->getPassword()));
            $doctrine->persist($register);
            $doctrine->flush();
            $this->addFlash("ok", "Usuario registrado correctamente");
            return $this->redirectToRoute("getApartments");
        }
        return $this->renderForm('apartment/register.html.twig', ["registerForm" => $form]);
    }
}
