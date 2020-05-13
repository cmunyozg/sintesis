<?php
namespace App\Controller;

use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController
{
    /**
     * Obtiene las categorias de la BBDD para renderizarlas por Twig en el DropItem del menú
     */
    public function categoriasMenu()
    {
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository(Categoria::class)->findAll();

        return $this->render('_categorias_menu.html.twig', [
            'categorias' => $categorias
        ]);
    }
}
