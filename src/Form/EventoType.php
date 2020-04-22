<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('fechaInicio', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fechaFin', DateType::class, [
                'widget' => 'single_text',
                'help' => 'Opcional.',
                'required' => false
            ])
            ->add('hora')
            ->add('ubicacion', TextType::class,[
                'help' => 'Por ejemplo: Teatro Flash o Discoteca Power'
            ])
            ->add('coordenadas')
            ->add('precio')
            ->add('descripcion')
            ->add('imagen')
            ->add('web', UrlType::class)
            ->add('categoria')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
