<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Form\Model\ChangePasswd;
use App\Form\ChangePasswdType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        if ($id == $this->getUser()->getId()) {

            $form = $this->createForm(UsuarioType::class, $usuario);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                  /** @var UploadedFile $brochureFile */
                  $brochureFile = $form['imagen']->getData();

                  // Si hay imagen para subir
                  if ($brochureFile) {
                      // Transforma el nombre del archivo
                      $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                      $safeFilename = iconv('UTF-8', 'ASCII//TRANSLIT', $originalFilename);
                      // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                      $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();
                      try {
                          // Mueve la imagen a la ruta especificada en services.yaml/parameters
                          $brochureFile->move(
                              $this->getParameter('imagenes_usuarios'),
                              $newFilename
                          );
                      } catch (FileException $e) {
                          // MOSTRAR ERROR EN LA SUBIDA
  
                      }
                      $usuario->setImagen($newFilename);
                  }

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('usuario_edit', ['id' => $usuario->getId()]);
            }

            return $this->render('usuario/edit.html.twig', [
                'usuario' => $usuario,
                'form' => $form->createView(),
            ]);
        } else throw new AccessDeniedException();
    }

    /**
     * @Route("/changePasswd", name="change_passwd", methods={"GET", "POST"})
     */
    public function cambiarPasswd(Request $request, ChangePasswd $changepasswd, UserPasswordEncoderInterface $encoder)
    {
        $changepasswd = new ChangePasswd();
        $form = $this->createForm(ChangePasswdType::class, $changepasswd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $this->getUser();
            $usuario->setPasswd(
                $encoder->encodePassword(
                    $usuario,
                    $changepasswd->getNew()
                )
            );
            $em->persist($usuario);
            $em->flush();
        }
        return $this->render('usuario/change_passwd.html.twig', array(
            'form' => $form->createView()
        ));
    }



    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete' . $usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }
}
