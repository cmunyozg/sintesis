<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Repository\EventoRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BuscadorController extends AbstractController
{
    /**
     * @Route("/", name="principal", methods={"GET"})
     * Página principal. Muestra los eventos de los próximos 7 dias.
     */
    public function principal(EventoRepository $eventRepository)
    {
        $today = (new \DateTime())->format('Y-m-d');
        $next7Days = (new \DateTime('+7days'))->format('Y-m-d');

        $eventos = $eventRepository->findEvents(null, 0, $today, $next7Days, false);
        return $this->render('buscador/principal.html.twig', [
            'categorias' => $this->getDoctrine()->getManager()->getRepository(Categoria::class)->findAll(),
            'eventos' => $eventos,
            'inicio' => $today,
            'fin' => $next7Days
        ]);
    }

  

    /**
     * @Route("/", name="buscador", methods={"POST"})
     * Gestiona la búsqueda de eventos mediante criterios de búsqueda
     */
    public function busqueda(Request $request, CategoriaRepository $catRepository, EventoRepository $eventRepository)
    {
  

        $clave = $request->request->get('clave');
        $categoriaID = $request->request->get('categoria');
        $inicio = $request->request->get('desde');
        $fin = $request->request->get('hasta');
        $gratis = $request->request->get('gratuito');

        if (empty($clave)) $clave = null;
        if (empty($categoriaID)) $categoriaID = null;
        if (empty($inicio)) $inicio = null;
        if (empty($fin)) $fin = null;
        if (!empty($gratis)) $gratis = true; else $gratis = false;

        $eventos = $eventRepository->findEvents($clave, $categoriaID, $inicio, $fin, $gratis);

        return $this->render('buscador/principal.html.twig', [
            'categorias' => $this->getDoctrine()->getManager()->getRepository(Categoria::class)->findAll(),
            'clave' => $clave,
            'idCategoria' => $categoriaID,
            'inicio' => $inicio,
            'fin' => $fin,
            'gratis' => $gratis,
            'eventos' => $eventos
        ]);
    }

      /**
     * @Route("/cat/{idCategoria}", name="categorias", methods={"GET"})
     * Busca todos los eventos de una categoría concreta de fecha vigente.
     */
    public function categorias($idCategoria, EventoRepository $eventRepository, CategoriaRepository $catRepository)
    {
        $eventos = $eventRepository->findByCategoria($idCategoria);
        $categoria = $catRepository->find($idCategoria);
        return $this->render('buscador/principal.html.twig', [
            'categorias' => $this->getDoctrine()->getManager()->getRepository(Categoria::class)->findAll(),
            'idCategoria' => $idCategoria,
            'titulo' => $categoria->getNombre(),
            'eventos' => $eventos,
        ]);
    }
}
