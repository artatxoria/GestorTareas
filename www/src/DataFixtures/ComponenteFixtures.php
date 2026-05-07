<?php

namespace App\DataFixtures;

use App\Entity\Componente;
use App\Entity\Tarea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ComponenteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tareaRepository = $manager->getRepository(Tarea::class);
        
        // Obtenemos las primeras 10 tareas disponibles
        $tareas = $tareaRepository->findBy([], null, 10);

        // Catálogo de componentes con su descripción añadida
        $catalogo = [
            ['nombre' => 'Licencia software', 'coste' => 5000, 'descripcion' => 'Suscripción anual para el entorno de desarrollo.'],
            ['nombre' => 'Servidor VPS', 'coste' => 2000, 'descripcion' => 'Instancia cloud para despliegue en staging.'],
            ['nombre' => 'Certificado SSL', 'coste' => 500,  'descripcion' => 'Certificado de seguridad para dominio principal.'],
            ['nombre' => 'Dominio .com', 'coste' => 1200,    'descripcion' => 'Registro de dominio por un periodo de 12 meses.'],
            ['nombre' => 'API Key', 'coste' => 1000,         'descripcion' => 'Token de acceso a servicios externos de terceros.'],
            ['nombre' => 'Créditos GPU', 'coste' => 4000,    'descripcion' => 'Consumo de cómputo para procesamiento de datos.'],
            ['nombre' => 'Soporte premium', 'coste' => 3000, 'descripcion' => 'Atención prioritaria y resolución de incidencias.'],
        ];

        foreach ($tareas as $tarea) {
            // Asignamos entre 1 y 3 tipos de componentes por tarea
            $numComponentes = rand(1, 3);
            
            for ($i = 0; $i < $numComponentes; $i++) {
                // Elegimos un componente al azar
                $datos = $catalogo[array_rand($catalogo)];
                
                $componente = new Componente();
                $componente->setNombre($datos['nombre']);
                $componente->setCoste($datos['coste']);
                $componente->setDescripcion($datos['descripcion']);
                $componente->setCantidad(rand(1, 5)); 
                $componente->setTarea($tarea);

                $manager->persist($componente);
            }
        }

        $manager->flush();
    }
}