<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Repository\ChantierRepository;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\LienRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        /**
        * Correspond à la page d'accueil sans la navbar
        * Pas de logique, juste du HTML/CSS directement dans le fichier home/home.html.twig
        */ 

        return $this->render('home/home.html.twig', [
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentation(): Response
    {
        /**
        * Correspond à la page présentation
        * Pas de logique, juste du HTML/CSS directement dans le fichier home/presentation.html.twig
        */ 

        return $this->render('home/presentation.html.twig', [
        ]);
    }

    /**
     * @Route("/expertise", name="expertise")
     */
    public function expertise(): Response
    {
        /**
        * Correspond à la page expertise
        * Pas de logique, juste du HTML/CSS directement dans le fichier home/expertise.html.twig
        */ 

        return $this->render('home/expertise.html.twig', [
        ]);
    }

    /**
     * @Route("/prestataire", name="prestataire")
     */
    public function prestataire(): Response
    {
        /**
        * Correspond à la page prestataire
        * Pas de logique, juste du HTML/CSS directement dans le fichier home/prestataire.html.twig
        */ 

        return $this->render('home/prestataire.html.twig', [
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre message a été envoyé correctement, merci et à bientôt !'
            );

            return $this->redirectToRoute('contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/contact.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/liens", name="liens")
     */
    public function liens(LienRepository $repo): Response
    {
        /**
        * Correspond à la page liens
        * Possibilité d'avoir de la logique si besoin de stocker les liens en BDD 
        * -> en créant une entité lien : titre|string, url|string
        * Ou de faire une page en dur en écrivant les liens directement dans le fichier twig
        */ 

        $liens = $repo->findAll();

        return $this->render('home/liens.html.twig', [
            'liens' => $liens,
        ]);
    }

   

}
