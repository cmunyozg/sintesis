<?php

namespace App\Command;

use App\Repository\SuscripcionRepository;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


// Debería ejecutarse cada hora en punto (12:00, 13:00, etc.)
// php /home/carlos/sintesis/bin/console app:suscrip
class SuscripCommand extends Command
{
    //nombre del comando
    protected static $defaultName = 'app:suscrip';
    private $twig;
    private $em;
    private $mailer;
    private $suscripRepo;

    public function __construct(Environment $twig, EntityManagerInterface $em, \Swift_Mailer $mailer, SuscripcionRepository $suscripRepo)
    {
        $this->twig = $twig;
        $this->em = $em;
        $this->mailer = $mailer;
        $this->suscripRepo = $suscripRepo;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tomorrow = new \DateTime('tomorrow');
        // Devuelve las suscripciones de los eventos que empiezan al día siguiente
        $suscripciones = $this->suscripRepo->findByDate($tomorrow, $tomorrow);

        foreach ($suscripciones as $suscrip) {
            $enviado = 'no'; //debug
            $event = $suscrip->getEvento();
            $user = $suscrip->getUsuario();
            $horaEvento = $event->getHora()->format('H:i');
            $diaEvento =  $event->getFechaInicio()->format('Y-m-d');
            $dateEvento = new \DateTime($diaEvento . ' ' . $horaEvento);
            $now =  new \DateTime();
            // Devuelve: días restantes - horas restantes para el evento (ej: 1-1 -> 1 día y 1 hora)
            // Se omiten minutos porque el script debe ejecutarse cada hora
            $diff = $now->diff($dateEvento)->format('%d-%h');

            //Si queda 1 día y 0 horas se envía correo al usuario
            if ($diff == '1-0') {
                $message = (new \Swift_Message())
                    ->setFrom(['sintesis095@gmail.com' => 'Síntesis'])
                    ->setTo($user->getEmail())
                    ->setSubject("Síntesis | " . $event->getTitulo())
                    ->setBody(
                        $this->twig->render(
                            'emails/suscrip.html.twig',
                            [
                                'user' => $user,
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                if ($this->mailer->send($message)) $enviado = 'si'; //debug
            }
            // debug
            // $output->writeln([
            //     $now->format('Y-m-d H:i'),
            //     $dateEvento->format('Y-m-d H:i'),
            //     $diff,
            //     $enviado,
            //     '----------------'
            // ]);
        }
        return 0;
    }
}
