<?php

namespace App\DataFixtures;

use App\Entity\Tarea;
use App\Entity\Usuario;
use App\Enum\TareaEstadoEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TareaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // 1. Recuperamos los objetos Usuario
        $ander = $this->getReference(UsuarioFixtures::USER_ANDER, Usuario::class);
        $nerea = $this->getReference(UsuarioFixtures::USER_NEREA, Usuario::class);

        // 2. Definimos las tareas pasando el OBJETO directamente
        $tareas = [
            ['Tarea 1 Ander', 'Desc 1', TareaEstadoEnum::PENDIENTE, 5, $ander],
            ['Tarea 2 Ander', 'Desc 2', TareaEstadoEnum::PENDIENTE, 8, $ander],
            ['Tarea 3 Ander', 'Desc 3', TareaEstadoEnum::PENDIENTE, 3, $ander],
            ['Tarea 1 Nerea', 'Desc 1', TareaEstadoEnum::PENDIENTE, 9, $nerea],
            ['Tarea 2 Nerea', 'Desc 2', TareaEstadoEnum::PENDIENTE, 2, $nerea],
            ['Tarea 3 Nerea', 'Desc 3', TareaEstadoEnum::PENDIENTE, 7, $nerea],
        ];

        // 3. Procesamos
        foreach ($tareas as $data) {
            $t = new Tarea();
            $t->setTitulo($data[0])
              ->setDescripcion($data[1])
              ->setEstado($data[2])
              ->setPrioridad($data[3])
              ->setPropietario($data[4]) // Aquí estamos pasando el objeto $ander o $nerea
              ->setFechaLimite(new \DateTimeImmutable());

            $manager->persist($t);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UsuarioFixtures::class];
    }
}