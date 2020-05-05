<?php

namespace App\Controller;

use App\Entity\Reporte;
use App\Form\ReporteType;
use App\Repository\ReporteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reporte")
 */
class ReporteController extends AbstractController
{
    /**
     * @Route("/", name="reporte_index", methods={"GET"})
     */
    public function index(ReporteRepository $reporteRepository): Response
    {
        return $this->render('reporte/index.html.twig', [
            'reportes' => $reporteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reporte_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reporte = new Reporte();
        $form = $this->createForm(ReporteType::class, $reporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reporte);
            $entityManager->flush();

            return $this->redirectToRoute('reporte_index');
        }

        return $this->render('reporte/new.html.twig', [
            'reporte' => $reporte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reporte_show", methods={"GET"})
     */
    public function show(Reporte $reporte): Response
    {
        return $this->render('reporte/show.html.twig', [
            'reporte' => $reporte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reporte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reporte $reporte): Response
    {
        $form = $this->createForm(ReporteType::class, $reporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reporte_index');
        }

        return $this->render('reporte/edit.html.twig', [
            'reporte' => $reporte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reporte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reporte $reporte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reporte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reporte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reporte_index');
    }
}
