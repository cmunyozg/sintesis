<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Form\Model\ChangePasswd;
use App\Form\ChangePasswdType;
use Symfony\Component\HttpFoundation\Session\Session;

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
 * 
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/datos", name="usuario_datos")
     * @IsGranted("ROLE_USER")
     * Muestra al usuario sus datos
     */
    public function datos(): Response
    {

        return $this->render('usuario/data.html.twig', [
            'usuario' => $this->getUser(),
        ]);
    }



    /**
     * @Route("/{id}", name="usuario_perfil")
     * Perfil público del usuario
     */
    public function perfil(Usuario $user): Response
    {
        if (count($eventos = $user->getEventos()) > 0);
        else $eventos = null;

        $actuales = array();
        $pasados = array();
        if ($eventos) {
            $today = new \DateTime('today');
            foreach ($eventos as $evento) {
                if (!$evento->getBloqueado() && $evento->getVisible()) {
                    if ($evento->getFechaInicio() < $today) array_push($pasados, $evento);
                    else array_push($actuales, $evento);
                }
            }
        }

        return $this->render('usuario/perfil.html.twig', [
            'usuario' => $user,
            'actuales' => $actuales,
            'pasados' => $pasados
        ]);
    }



    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * Edita los datos del usuario, cambia su contraseña o elimina el usuario en función del formulario que complete.
     */
    public function edit(Request $request, Usuario $usuario, $id, ChangePasswd $changepasswd, UserPasswordEncoderInterface $encoder): Response
    {
        // Sólo permite editar si la id conincide con la del usuario logeado, si no deniega acceso.
        if ($id == $this->getUser()->getId()) {

            $mensaje = null;
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(UsuarioType::class, $usuario);
            $form->handleRequest($request);

            $changepasswd = new ChangePasswd();
            $formPasswd = $this->createForm(ChangePasswdType::class, $changepasswd);
            $formPasswd->handleRequest($request);

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
                        $mensaje = 2; // error

                    }
                    $usuario->setImagen($newFilename);
                }

                try {
                    $this->getDoctrine()->getManager()->flush();
                    $mensaje = 1; //exito
                } catch (\Exception $e) {
                    $mensaje = 2; // error

                };
            }

            if ($formPasswd->isSubmitted()) {
                if ($formPasswd->isValid()) {
                    try {
                        $usuario = $this->getUser();
                        $usuario->setPasswd(
                            $encoder->encodePassword(
                                $usuario,
                                $changepasswd->getNew()
                            )
                        );

                        $em->persist($usuario);
                        $em->flush();
                        $mensaje = 1; //exito
                    } catch (\Exception $e) {
                        $mensaje = 2; // error

                    }
                } else $mensaje = 2;
            }

            // Elimina suario si se ha hecho uso del formulario delete
            if ($passwd = $request->request->get('passwd', false)) {
                // Si la contraseña introducida es la del usuario, lo elimina y borra la sesión
                if ($encoder->isPasswordValid($usuario, $passwd)) {
                    $em->remove($usuario);
                    $em->flush();
                    $request->getSession()->invalidate();
                    return $this->redirectToRoute('app_logout');
                } else {
                    $mensaje = 2;
                }
            }


            return $this->render('usuario/edit.html.twig', [
                'usuario' => $usuario,
                'form' => $form->createView(),
                'formPasswd' => $formPasswd->createView(),
                'mensaje' => $mensaje
            ]);
        } else throw new AccessDeniedException();
    }

}
