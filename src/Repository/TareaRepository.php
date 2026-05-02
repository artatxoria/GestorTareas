<?php

namespace App\Repository;

use App\Model\Tarea;
use Psr\Log\LoggerInterface;

class TareaRepository
{
    
    // Al añadir "private", PHP crea la propiedad y le asigna el valor automaticamente
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function findAll(): array
    {
        $this->logger->info('Consultando la lista de tareas...');
    
        // En el futuro, aqui residira la logica de Doctrine (SQL).
        // Por ahora, "fabricamos" los datos manualmente para probar el flujo.
        return [
            new Tarea(1, 'Revisar informe trimestral', 'Preparar presentación para dirección', 'pendiente', new \DateTimeImmutable('2026-04-20'),1),
			new Tarea(2, 'Comprar material oficina', 'Toner impresoras y papel A4', 'completada', new \DateTimeImmutable('2026-04-10'),9),
			new Tarea(3, 'Actualizar documentación', 'API endpoints del proyecto', 'en_progreso', new \DateTimeImmutable('2026-04-25'),9),
        ];
    }

    public function findTareaById(int $id): ?Tarea
    {
        $tareas = $this->findAll();
    
        foreach ($tareas as $tarea)
        {
            if ($tarea ->getId() === $id)
            {
                return $tarea;
            }
        }
        return null;
    }

    public function findByStatus(string $status): array
	{
	    return array_filter($this->findAll(), fn($t) => $t->getEstado() === $status);
	}

    public function findByTerm(string $term): ?Tarea
	{
	    foreach ($this->findAll() as $tarea) {
	        if (false !== stripos($tarea->getTitulo(), $term)) {
	            return $tarea;
	        }
	    }
	    return null;
	}
}