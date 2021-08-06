<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ChantierRepository;
use App\Entity\Chantier;

class PortfolioController extends AbstractController
{
    /**
    * @Route("/portfolio", name="portfolio_index")
    */
    public function portfolio(ChantierRepository $repo): Response
    {
        $indiv = $repo->findType('indiv');
        $coll = $repo->findType('coll');
        $erp = $repo->findType('erp');
        

        return $this->render('portfolio/index.html.twig', [
            'indiv' => $indiv,
            'coll' => $coll,
            'erp' => $erp,
        ]);
    }

    /**
    * @Route("/portfolio/chantiers/{type}", name="portfolio_chantiers")
    */
    public function chantiers(ChantierRepository $repo, $type): Response
    {
        $chantiers = $repo->findType($type);
        
        $titre = $this->formatedType($type);
      
        return $this->render('portfolio/chantiers.html.twig', [
            'chantiers' => $chantiers,
            'titre' => $titre,
        ]);
    }

    /**
    * @Route("/portfolio/chantier/{id}", name="portfolio_chantier_show")
    */
    public function show(Chantier $chantier): Response
    {

        dump($chantier);
      $type = $this->formatedType($chantier->getType());
        return $this->render('portfolio/show.html.twig', [
            'chantier' => $chantier,
            'type' => $type,
        ]);
    }

    public function formatedType($type){

        if($type == 'coll'){
            return 'Logements collectifs';
        }
        elseif($type == 'indiv'){
            return 'Logements individuels';
        }
        elseif($type == 'erp'){
            return 'Etablissement recevant du public';
        }
    }
}
