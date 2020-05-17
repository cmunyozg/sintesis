<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class, [
                'label' => 'Nombre de Usuario'
            ])
            ->add('nombre', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'help' => 'Debe contener al menos 6 caracteres.',
                'label' => 'Contraseña',
                'constraints' => [

                    new NotBlank([
                        'message' => 'Campo requerido.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                ],
            ])
            ->add('fechaNacimiento',
                DateType::class,
                [
                    'label' => 'Fecha de Nacimiento',
                    'widget' => 'single_text',
                    'view_timezone' => 'Europe/Madrid',
                    // 'format' => 'd / MMMM / yyyy',
                    // 'years' => $this->getYears()
                ]
            )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Aceptar términos y condiciones',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debes aceptar los términos.',
                    ]),
                ],
            ])
            ->add('registrarse', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-lg mt-2']
            ]);
    }

    // Años de nacimiento para usuarios de 16 - 90 años
    // public function getYears(): array
    // {
    //     $actualYear = (new \DateTime())->format('Y');
    //     $max = $actualYear - 16;
    //     $min = $actualYear - 90;
    //     $arrayYears = [];

    //     for ($i = $max; $i >= $min; $i--) {
    //         array_push($arrayYears, $i);
    //     }
    //     return $arrayYears;
    // }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
