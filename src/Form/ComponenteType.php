<?php

namespace App\Form;

use App\Entity\Componente;
use App\Entity\Tarea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('coste')
            ->add('cantidad')
            ->add('descripcion')
            ->add('tarea', EntityType::class, [
                'class' => Tarea::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Componente::class,
        ]);
    }
}
