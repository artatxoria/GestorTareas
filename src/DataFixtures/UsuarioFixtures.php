<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsuarioFixtures extends Fixture
{
    public const USER_ANDER = 'user_ander';
    public const USER_NEREA = 'user_nerea';

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['Ander', 'Lipus', 'ander@example.com', '600000001', 'Bilbao', 'País Vasco', '11111111-A', 'male'],
            ['Nerea', 'Ankarte', 'nerea@example.com', '600000002', 'San Sebastián', 'País Vasco', '22222222-B', 'female'],
        ];

        foreach ($users as $data) {
            $u = new Usuario();
            $u->setNombre($data[0])->setApellido($data[1])->setEmail($data[2])
              ->setTelefono($data[3])->setCiudad($data[4])->setComunidad($data[5])
              ->setDni($data[6])->setGenero($data[7]);

            $manager->persist($u);
            
            // Guardamos referencia para usarla en TareaFixtures
            $this->addReference($data[0] === 'Ander' ? self::USER_ANDER : self::USER_NEREA, $u);
        }

        $manager->flush();
    }
}