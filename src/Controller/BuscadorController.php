<?php

namespace App\Controller;

use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuscadorController extends AbstractController
{
    /**
     * @Route("/buscador", name="buscador")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository(Categoria::class)->findAll();

        return $this->render('buscador/index.html.twig', [
            'categorias' => $categorias,
        ]);
    }
}