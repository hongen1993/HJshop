<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Posts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('foto', FileType::class,['label' => 'Seleccionar foto A','mapped' => false, 'required' => 'false'])
            ->add('fotoB', FileType::class,['label' => 'Seleccionar foto B','mapped' => false, 'required' => 'false'])
            ->add('contenido', TextareaType::class)
            ->add('precioAntes', MoneyType::class)
            ->add('precio', MoneyType::class)
            ->add('sku')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
