<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Entity\Reporte;
use App\Form\ReporteType;
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
 * @Route("/event")
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
     * @Route("/actives", name="event_active_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * Muestra al administrador los eventos activos (aún no ha cumplido la fecha de inicio o de fin del evento y no están bloqueados)
     */
    public function eventosActivos(EventoRepository $eventoRepository): Response
    {
        $events = $eventoRepository->findAll();
        $activos = array();
        $now = new \DateTime();

        for ($i = 0; $i < count($events); $i++) {
            if ($fechaFin = $events[$i]->getFechaFin()) {
                if ($fechaFin > $now) array_push($activos, $events[$i]);
            } else {
                if ($events[$i]->getFechaInicio() > $now && !$events[$i]->getBloqueado()) array_push($activos, $events[$i]);
            }
        }

        return $this->render('evento/active_index.html.twig', [
            'eventos' => $activos,
        ]);
    }

    /**
     * @Route("/block", name="block_event", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function bloquearEvento(Request $request, EventoRepository $eventRepository, \Swift_Mailer $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $eventoID = $request->request->get('eventoID');
        $mensajeModeracion = $request->request->get('mensaje');
        $event = $eventRepository->find($eventoID);

        if ($event->getBloqueado() == false) {
            $event->setBloqueado(true);
            $event->setMensajeModeracion($mensajeModeracion);
            $em->persist($event);
            $em->flush();

            // Envío de email
            $message = (new \Swift_Message())
                ->setFrom(['sintesis095@gmail.com' => 'Síntesis'])
                ->setTo($event->getUsuario()->getEmail())
                ->setSubject("Hemos bloqueado una de tus publicaciones.")
                ->setBody(
                    $this->renderView(
                        'emails/block.html.twig',
                        ['user' => $event->getUsuario(),
                        'event' => $event]
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }

        return $this->redirectToRoute('reporte_index');
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
                $safeFilename = iconv('UTF-8', 'ASCII//TRANSLIT', $originalFilename);
                // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
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
     * @Route("/{id}", name="evento_show", methods={"GET", "POST"})
     */
    public function show(Evento $evento, SuscripcionRepository $suscripRepository, Request $request): Response
    {
        // Formulario para reportes de eventos
        $reporte = new Reporte();
        $form = $this->createForm(ReporteType::class, $reporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reporte->setEvento($evento);
            $entityManager->persist($reporte);
            $entityManager->flush();
        }

        // Muestra/oculta el botón de suscripción
        $suscrito = false;
        if ($user = $this->getUser()) {
            if ($suscrip = $suscripRepository->findByUserAndEvent($user, $evento))
                $user->getSuscripciones()->contains($suscrip[0]) ? $suscrito = true : $suscrito = false;
        }

        return $this->render('evento/show.html.twig', [
            'evento' => $evento,
            'descripcion' => nl2br($evento->getDescripcion()),
            'suscrito' => $suscrito,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evento_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evento $evento): Response
    {
        // Sólo permite editar si el usuario logeado es el creador del evento, si no deniega acceso.
        if ($evento->getUsuario() == $this->getUser()) {
            $mensaje = null;
            $form = $this->createForm(EventoType::class, $evento);
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
                            $this->getParameter('imagenes_eventos'),
                            $newFilename
                        );
                        $evento->setImagen($newFilename);
                    } catch (FileException $e) {
                        $mensaje = 2; //error
                    }
                }

                try {
                    $this->getDoctrine()->getManager()->flush();
                    $mensaje = 1; //exito
                } catch (\Exception $e) {
                        $mensaje = 2; //error
                   
                }
            }

            return $this->render('evento/edit.html.twig', [
                'evento' => $evento,
                'form' => $form->createView(),
                'mensaje' => $mensaje

            ]);
        } else throw new AccessDeniedException();
    }

    /**
     * @Route("/visibility/{id}", name="event_visibility", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * El evento desaparece de la lista de eventos del perfil del usuario, aunque sigue accesible si se tiene la ruta URL.
     * Si ya estaba oculto, lo vuelve a mostrar
     */
    public function visibleOinvisible(Evento $event): Response
    {
        // Sólo permite editar si el usuario logeado es el creador del evento, si no deniega acceso.
        if ($event->getUsuario() == $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            if ($event->getVisible() == true) $event->setVisible(false);
            else $event->setVisible(true);
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('evento_index');
        } else throw new AccessDeniedException();
    }


    /**
     * @Route("/unblock/{id}", name="unblock_event", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function desbloquearEvento($id, EventoRepository $eventRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $event = $eventRepository->find($id);

        if ($event->getBloqueado() == true) {
            $event->setBloqueado(false);
            $event->setMensajeModeracion('');
            $em->persist($event);
            $em->flush();
        }

        return $this->redirectToRoute('block_event_index');
    }

    /**
     * @Route("/block/index", name="block_event_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function eventosBloqueados(EventoRepository $eventoRepository)
    {

        $eventos = $eventoRepository->findAll();
        $eventosBloqueados = array();
        for ($i = 0; $i < count($eventos); $i++) {
            if ($eventos[$i]->getBloqueado() == true) array_push($eventosBloqueados, $eventos[$i]);
        }
        return $this->render('evento/block_index.html.twig', [
            'bloqueados' => $eventosBloqueados
        ]);
    }

    /**
     * @Route("/delete/{id}", name="evento_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Evento $evento): Response
    {
        if ($evento->getUsuario() == $this->getUser()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evento);
            $entityManager->flush();
        } else throw new AccessDeniedException();

        return $this->redirectToRoute('evento_index');
    }
}
