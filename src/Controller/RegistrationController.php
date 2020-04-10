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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $alias = $form['alias']->getData();
            $nombre = $form['nombre']->getData();
            $email = $form['email']->getData();
            $plainPassword = $form['plainPassword']->getData();
            $fechaNacimiento = $form['fechaNacimiento']->getData();
            $fechaRegistro = new \DateTime();

            $user->setAlias($alias)
                ->setNombre($nombre)
                ->setEmail($email)
                ->setFechaNacimiento($fechaNacimiento)
                ->setFechaRegistro($fechaRegistro)
                ->setRol(0);

            // encode the plain password
            $user->setPasswd(
                $passwordEncoder->encodePassword(
                    $user,
                    $plainPassword
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

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
