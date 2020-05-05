<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('alias', TextType::class, [
                'label' => 'Nombre de Usuario'
            ])
            ->add('email', EmailType::class)
            ->add(
                'fechaNacimiento',
                DateType::class,
                [
                    'label' => 'Fecha de Nacimiento',
                    'label_attr' => ['class' => 'pt-0'],
                    'widget' => 'choice',
                    'view_timezone' => 'Europe/Madrid',
                    'format' => 'd / MMMM / yyyy',
                    'years' => $this->getYears()
                ]
            )
            ->add('imagen', FileType::class, [
                'label' => 'Imagen',
                'mapped' => false,
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Archivo no válido.',
                    ]),
                ],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false
            ]);
    }

    public function getYears(): array
    {
        $actualYear = (new \DateTime())->format('Y');
        $max = $actualYear - 16;
        $min = $actualYear - 90;
        $arrayYears = [];

        for ($i = $max; $i >= $min; $i--) {
            array_push($arrayYears, $i);
        }
        return $arrayYears;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
