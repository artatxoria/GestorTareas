<?php
// src/Form/UsuarioType.php
namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('apellido', TextType::class, ['label' => 'Apellido'])
            ->add('email', EmailType::class, ['label' => 'Correo Electrónico'])
            ->add('telefono', TextType::class, ['label' => 'Teléfono'])
            ->add('ciudad', TextType::class, ['label' => 'Ciudad'])
            ->add('comunidad', TextType::class, ['label' => 'Comunidad'])
            ->add('dni', TextType::class, ['label' => 'DNI'])
            ->add('genero', ChoiceType::class, [
                'label' => 'Género',
                'choices' => ['Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro']
            ])
            ->add('fotografia', TextType::class, ['label' => 'URL Foto', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Usuario::class]);
    }
}
