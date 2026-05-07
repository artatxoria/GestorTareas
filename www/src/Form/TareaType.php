<?php

namespace App\Form;

use App\Entity\Tarea;
use App\Entity\Usuario;
use App\Enum\TareaEstadoEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TareaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo de texto simple para el título
            ->add('titulo', TextType::class, [
                'label' => 'Título de la Tarea',
                'attr' => ['placeholder' => 'Ej: Revisar informes trimestrales']
            ])
            
            // Área de texto para la descripción larga
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción detallada',
                'required' => false,
                'attr' => ['rows' => 3, 'placeholder' => 'Añade más información aquí...']
            ])
            
            // Selector basado en tu TareaEstadoEnum (Pendiente, En progreso, etc.)
            ->add('estado', EnumType::class, [
                'class' => TareaEstadoEnum::class,
                'label' => 'Estado de la tarea',
            ])
            
            // Selector de fecha (renderiza un calendario nativo en el navegador)
            ->add('fechaLimite', DateType::class, [
                'label' => 'Fecha de vencimiento',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            
            // Campo numérico para la prioridad
            ->add('prioridad', IntegerType::class, [
                'label' => 'Prioridad (1-10)',
                'attr' => ['min' => 1, 'max' => 10]
            ])
            
            // EL DESPLEGABLE DE USUARIOS:
            // Aquí es donde vinculamos la tarea con un Usuario existente
            ->add('propietario', EntityType::class, [
                'class' => Usuario::class,
                'label' => 'Responsable asignado',
                'placeholder' => 'Selecciona al usuario responsable...',
                
                // Esta función personaliza qué texto aparece en cada opción del select
                'choice_label' => function (Usuario $usuario) {
                    return $usuario->getNombre() . ' ' . $usuario->getApellido();
                },
                
                // Opcional: podrías ordenar los usuarios alfabéticamente aquí
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarea::class,
        ]);
    }
}
