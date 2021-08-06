<?php

namespace App\Controller\Admin;

use App\Entity\Lien;
use App\Form\LienType;
use App\Repository\LienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lien")
 */
class LienController extends AbstractController
{
    /**
     * @Route("/", name="admin_lien_index", methods={"GET"})
     */
    public function index(LienRepository $lienRepository): Response
    {
        return $this->render('admin/lien/index.html.twig', [
            'liens' => $lienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_lien_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lien = new Lien();
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lien);
            $entityManager->flush();

            return $this->redirectToRoute('admin_lien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lien/new.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_lien_show", methods={"GET"})
     */
    public function show(Lien $lien): Response
    {
        return $this->render('admin/lien/show.html.twig', [
            'lien' => $lien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_lien_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lien $lien): Response
    {
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_lien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lien/edit.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_lien_delete", methods={"POST"})
     */
    public function delete(Request $request, Lien $lien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_lien_index', [], Response::HTTP_SEE_OTHER);
    }
}
