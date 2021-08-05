<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/admin/user")
 */
class RegistrationController extends AbstractController
{

    /**
     * @Route("/list", name="index_users")
     */
    public function list_users(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();
        return $this->render('registration/index.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index_users');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/promote/{id}", name="user_promote")
     */
    public function promote(User $user): Response
    {
        $roles = array('ROLE_USER', 'ROLE_ADMIN');
        $user->setRoles($roles);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();


        return $this->redirectToRoute('index_users');

    }
    /**
     * @Route("/demote/{id}", name="user_demote")
     */
    public function demote(User $user): Response
    {
        $roles = array('ROLE_USER');
        $user->setRoles($roles);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();


        return $this->redirectToRoute('index_users');

    }

    /**
     * @Route("/remove/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index_users');
    }
}

