<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, \Swift_Mailer $mailer): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $alias = $form['alias']->getData();
            $nombre = $form['nombre']->getData();
            $email = $form['email']->getData();
            $plainPassword = $form['password']->getData();
            $fechaNacimiento = $form['fechaNacimiento']->getData();
            $fechaRegistro = new \DateTime();

            $user->setAlias($alias)
                ->setNombre($nombre)
                ->setEmail($email)
                ->setFechaNacimiento($fechaNacimiento)
                ->setFechaRegistro($fechaRegistro)
                ->setRol(0);

            // encode password
            $user->setPasswd(
                $passwordEncoder->encodePassword(
                    $user,
                    $plainPassword
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Envío de email
            $message = (new \Swift_Message())
                ->setFrom(['sintesis095@gmail.com' => 'Síntesis'])
                ->setTo($user->getEmail())
                ->setSubject("Bienvenido a Síntesis")
                ->setBody(
                    $this->renderView(
                        'emails/registration.html.twig',
                        ['user' => $user]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
