<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use App\Entity\Suscripcion;
use App\Repository\SuscripcionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SuscripcionController extends AbstractController
{
    /**
     * @Route("/suscrip", name="suscripciones")
     * @IsGranted("ROLE_USER")
     * // COMPROBAR
     */
    public function index(SuscripcionRepository $suscripRepository)
    {
        $user = $this->getUser();
        $suscripciones = $suscripRepository->findByUser($user);
        $proximos = [];
        $pasados = [];
        $now = new \DateTime();

        for ($i = 0; $i < count($suscripciones); $i++){
            $event = $suscripciones[$i]->getEvento();
            $fechaIncio = $event->getFechaInicio();
            if ($fechaIncio > $now) array_push($proximos, $event);
            else array_push($pasados, $event);
          
        }
        
        return $this->render('suscripcion/index.html.twig', [
            'proximos' => $proximos,
            'pasados' => $pasados
        ]);
    }

       /**
     * @Route("/suscrip/add/{eventoID}", name="suscripcion_add")
     * @IsGranted("ROLE_USER")
     */
    public function addSuscripcion($eventoID, SuscripcionRepository $suscripRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $event = $em->find(Evento::class, $eventoID);

        // Si el usuario aún no se ha suscrito a ese evento
        if ($suscripRepository->findByUserAndEvent($user, $event) == null) {
            $suscrip = (new Suscripcion())->setEvento($event)->setUsuario($user);
            $em->persist($suscrip);
            $user->addSuscripcion($suscrip);
            $em->persist($user);
            $event->addSuscripcion($suscrip);
            $em->persist($event);
            $em->flush();
        }
        return $this->redirectToRoute('evento_show', ['id' => $eventoID]);
    }

    /**
     * @Route("/suscrip/remove/{eventoID}/{originPath}", name="suscripcion_remove")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function removeSuscripcion($eventoID, $originPath, SuscripcionRepository $suscripRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $event = $em->find(Evento::class, $eventoID);
        $suscrip = $suscripRepository->findByUserAndEvent($user, $event);
     
            $user->removeSuscripcion($suscrip[0]);
            $event->removeSuscripcion($suscrip[0]);
            $em->remove($suscrip[0]);
            $em->flush();
            
        if ($originPath == 'event')
        return $this->redirectToRoute('evento_show', ['id' => $eventoID]);
        else if ($originPath == 'suscrip') return $this->redirectToRoute('suscripciones');
    }
}
