<?php

namespace App\Controller;

use App\Entity\Reporte;
use App\Form\ReporteType;
use App\Repository\EventoRepository;
use App\Repository\ReporteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/reporte")
 * @IsGranted("ROLE_ADMIN")
 */
class ReporteController extends AbstractController
{
    /**
     * @Route("/", name="reporte_index", methods={"GET"})
     */
    public function index(ReporteRepository $reporteRepository, EventoRepository $eventoRepository): Response
    {
        $reportes = $reporteRepository->findAll();
        $reportesActuales = array();
        for ($i = 0; $i<count($reportes); $i++){
            if ($reportes[$i]->getEvento()->getBloqueado() == false) array_push($reportesActuales, $reportes[$i]);
        }


        return $this->render('reporte/index.html.twig', [
            'reportes' => $reportesActuales
        ]);
    }

    /**
     * @Route("/{id}", name="reporte_delete")
     */
    public function delete(Request $request, Reporte $reporte): Response
    {
      
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reporte);
            $entityManager->flush();

        return $this->redirectToRoute('reporte_index');
    }

  
}
