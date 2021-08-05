<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Repository\ChantierRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        /**
        * Correspond à la page contact
        * Logique pour récupérer les informations de contact par le biais d'un formulaire
        * et d'une entité contact
        */ 

        return $this->render('home/contact.html.twig', [
        ]);
    }

    /**
     * @Route("/liens", name="liens")
     */
    public function liens(): Response
    {
        /**
        * Correspond à la page liens
        * Possibilité d'avoir de la logique si besoin de stocker les liens en BDD 
        * -> en créant une entité lien : titre|string, url|string
        * Ou de faire une page en dur en écrivant les liens directement dans le fichier twig
        */ 

        return $this->render('home/liens.html.twig', [
        ]);
    }

    /**
    * @Route("/portfolio", name="portfolio")
    */
    public function portfolio(ChantierRepository $repo): Response
    {
        $indiv = $repo->findType('indiv');
        $coll = $repo->findType('coll');
        $erp = $repo->findType('erp');
        

        return $this->render('home/portfolio.html.twig', [
            'indiv' => $indiv,
            'coll' => $coll,
            'erp' => $erp,
        ]);
    }   

}
