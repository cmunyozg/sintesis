<?php

namespace App\Form;

use App\Form\Model\ChangePasswd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old', PasswordType::class, array(
                'label' => 'Contraseña actual',
            ))
            ->add(
                'new',
                RepeatedType::class,
                array(
                    "required" => "required",
                    'type' => PasswordType::class,
                    'invalid_message' => 'Ambas contraseñas deben coincidir',
                    'first_options' => array('label' => 'Contraseña nueva', "attr" => array("class" => "form-password form-control")),
                    'second_options' => array('label' => 'Repita la contraseña', "attr" => array("class" => "form-password form-control"))
                )
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Actualizar Contraseña',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangePasswd::class,
        ]);
    }
}
