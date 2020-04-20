<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/usuario")
 * @IsGranted("ROLE_USER")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/datos", name="usuario_datos")
     * 
     */
    public function show(): Response
    {

        return $this->render('usuario/show.html.twig', [
            'usuario' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario, $id): Response
    {
        // Sólo permite editar si la id conincide con la del usuario logeado, si no deniega acceso.
        if ($id == $this->getUser()->getId()){

            $form = $this->createForm(UsuarioType::class, $usuario);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('usuario_edit', ['id' => $usuario->getId()]);
            }
    
            return $this->render('usuario/edit.html.twig', [
                'usuario' => $usuario,
                'form' => $form->createView(),
            ]);
        }
        else throw new AccessDeniedException();
      
    }

    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }
}
