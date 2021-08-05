<?php

namespace App\Controller\Admin;

use App\Entity\Chantier;
use App\Form\ChantierType;
use App\Entity\Carousel;
use App\Repository\ChantierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/chantier")
 */
class ChantierController extends AbstractController
{
    /**
     * @Route("/", name="admin_chantier_index", methods={"GET"})
     */
    public function index(ChantierRepository $chantierRepository): Response
    {
        return $this->render('admin/chantier/index.html.twig', [
            'chantiers' => $chantierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_chantier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chantier = new Chantier();
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chantier);
            $entityManager->flush();

            return $this->redirectToRoute('admin_chantier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_chantier_show", methods={"GET"})
     */
    public function show(Chantier $chantier): Response
    {
        return $this->render('admin/chantier/show.html.twig', [
            'chantier' => $chantier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_chantier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chantier $chantier): Response
    {
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_chantier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_chantier_delete", methods={"POST"})
     */
    public function delete(Request $request, Chantier $chantier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chantier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_chantier_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/remove_carousel/{id}", name="admin_chantier_carousel_remove", methods={"GET","POST"})
     */
    public function removeCarousel(Request $request, Carousel $carousel): Response
    {
        $chantier = $carousel->getChantier();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($carousel);
        $entityManager->flush();

        return $this->redirectToRoute('admin_chantier_edit', ['id' => $chantier->getId()]);
    }
}
