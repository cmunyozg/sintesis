<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use App\Repository\SuscripcionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/evento")
 */
class EventoController extends AbstractController
{
    /**
     * @Route("/", name="evento_index", methods={"GET"})
     * Muestra los eventos del usuario logeado
     */
    public function index(EventoRepository $eventoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('evento/index.html.twig', [
            'eventos' => $eventoRepository->findByUsuario($this->getUser()),
        ]);
    }

    /**
     * @Route("/new", name="evento_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $evento = new Evento();
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $this->getUser();

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form['imagen']->getData();

            // Si hay imagen para subir
            if ($brochureFile) {
                // Transforma el nombre del archivo
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();
                try {
                    // Mueve la imagen a la ruta especificada en services.yaml/parameters
                    $brochureFile->move(
                        $this->getParameter('imagenes_eventos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $this->render('evento/edit.html.twig', [
                        'evento' => $evento,
                        'form' => $form->createView(),
                        'mensaje' => 2 //error
                    ]);
                }
                $evento->setImagen($newFilename);
            }

            $evento->setUsuario($usuario);
            $evento->setVisible(true);
            $evento->setBloqueado(false);
            $evento->setFechaPublicacion(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evento);

            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $this->render('evento/edit.html.twig', [
                    'evento' => $evento,
                    'form' => $form->createView(),
                    'mensaje' => 2 //error
                ]);
            }

            return $this->render('evento/edit.html.twig', [
                'evento' => $evento,
                'form' => $form->createView(),
                'mensaje' => 1 //éxito
            ]);
        }

        return $this->render('evento/new.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="evento_show", methods={"GET"})
     */
    public function show(Evento $evento, SuscripcionRepository $suscripRepository): Response
    {
        $suscrito = false;
        if ($user = $this->getUser()) {
            if ($suscrip = $suscripRepository->findByUserAndEvent($user, $evento))
                $user->getSuscripciones()->contains($suscrip[0]) ? $suscrito = true : $suscrito = false;
        }

        return $this->render('evento/show.html.twig', [
            'evento' => $evento,
            'suscrito' => $suscrito,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evento_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evento $evento): Response
    {
        // Sólo permite editar si el usuario logeado es el creador del evento o si es admin, si no deniega acceso.
        if ($evento->getUsuario() == $this->getUser() || $this->getUser()->getRol() == 1) {
            $form = $this->createForm(EventoType::class, $evento);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                /** @var UploadedFile $brochureFile */
                $brochureFile = $form['imagen']->getData();

                // Si hay imagen para subir
                if ($brochureFile) {
                    // Transforma el nombre del archivo
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();
                    try {
                        // Mueve la imagen a la ruta especificada en services.yaml/parameters
                        $brochureFile->move(
                            $this->getParameter('imagenes_eventos'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        return $this->render('evento/edit.html.twig', [
                            'evento' => $evento,
                            'form' => $form->createView(),
                            'mensaje' => 2 //error
                        ]);
                    }
                    $evento->setImagen($newFilename);
                }

                try {
                    $this->getDoctrine()->getManager()->flush();
                } catch (\Exception $e) {
                    return $this->render('evento/edit.html.twig', [
                        'evento' => $evento,
                        'form' => $form->createView(),
                        'mensaje' => 2 //error
                    ]);
                }

                return $this->render('evento/edit.html.twig', [
                    'evento' => $evento,
                    'form' => $form->createView(),
                    'mensaje' => 1 //éxito
                ]);
            }

            return $this->render('evento/edit.html.twig', [
                'evento' => $evento,
                'form' => $form->createView(),

            ]);
        } else throw new AccessDeniedException();
    }

    /**
     * @Route("/{id}", name="evento_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evento $evento): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evento->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evento_index');
    }
 
}
