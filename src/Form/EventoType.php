<?php

namespace App\Form;

use App\Entity\Evento;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título'
            ])
            ->add('fechaInicio', DateType::class, [
                'label' => 'Fecha de Inicio',
                'widget' => 'single_text',
            ])
            ->add('fechaFin', DateType::class, [
                'label' => 'Fecha de Fin',
                'widget' => 'single_text',
                'help' => 'Opcional. Para eventos de más de un día.',
                'required' => false
            ])
            ->add('hora', TimeType::class, [
                'widget' => 'choice',
                'label_attr' => ['class' => 'pt-0'],
                'minutes' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55]

            ])
            ->add('ubicacion', TextType::class, [
                'label' => 'Ubicación',
                'help' => 'Introduce un nombre de establecimiento o una dirección.'
            ])
            ->add('coordenadas', HiddenType::class)
            ->add('precio', MoneyType::class, [
                'divisor' => 100,
                'required' => false,
                'empty_data' => '0'
            ])
            ->add('descripcion', TextAreaType::class, [
                'label' => 'Descripción',
                'required' => false
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Imagen',
                'mapped' => false,
                'required' => false,
                'help' => 'Opcional.',
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
            ->add('web', UrlType::class, [
                'required' => false,
                'help' => 'Opcional.'
            ])
            ->add('categoria', null, [
                'label' => 'Categoría'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
