<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BuscadorController extends AbstractController
{
    /**
     * @Route("/", name="principal", methods={"GET"})
     * 
     */
    public function principal()
    {

        return $this->render('buscador/principal.html.twig', [
            'categorias' => $this->getDoctrine()->getManager()->getRepository(Categoria::class)->findAll(),
        ]);
    }

    /**
     * @Route("/{idCategoria}", name="categorias", methods={"GET"})
     * 
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

    /**
     * @Route("/", name="buscador", methods={"POST"})
     * 
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
        if (empty($gratis)) $gratis = null;

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
}
