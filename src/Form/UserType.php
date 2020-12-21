<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,array('attr' => array('class'=> 'form-control')))
//            ->add('roles')
            ->add('password', PasswordType::class)
//            ->add('baneado')
            ->add('nombre')
            ->add('apellidos')
            ->add('fechanacimiento', BirthdayType::class,[
                    // this is actually the default format for single_text
                    'format' => 'dd-MM-yyyy'])
            ->add('numerotelefono', TelType::class)
            ->add('provincia')
            ->add('codigopostal', NumberType::class )
            ->add('direccion')
            ->add('registrar', SubmitType::class)
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
