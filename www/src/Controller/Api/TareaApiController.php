<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Model\Tarea;
use Psr\Log\LoggerInterface;
use App\Repository\TareaRepository;

 #[Route('/api/tareas')]
final class TareaApiController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(TareaRepository $repository): Response
    {
        // Obtenemos todas las tareas desde nuestro servicio
	    $tareas = $repository->findAll();
	
	    //devuelve directamante un JSON
		return $this->json($tareas);
    }

    #[Route('/{id<\d+>}', methods: ['GET'])]
	public function detalle(int $id, TareaRepository $repository) 
    { 
        $tarea = $repository->findTareaById($id);
        return $this->json($tarea);
    }

    #[Route('/estado/{status<pendiente|en_progreso|completada>}', methods: ['GET'])]
	public function listarPorEstado(string $status, TareaRepository $repository): Response
	{
	    // 1. Llamamos al método del repositorio
	    $tareas = $repository->findByStatus($status);
	
	    // 2. Devolvemos la lista (Symfony la convertirá a JSON automáticamente)
	    return $this->json($tareas);
	}

    #[Route('/buscar/{term}', methods: ['GET'])]
	public function buscar(string $term, TareaRepository $repository): Response
	{
	    // 1. Pedimos al repositorio que busque UNA coincidencia
	    $tarea = $repository->findByTerm($term);
	
	    // 2. Validación: Si el repositorio devuelve null, lanzamos 404. 
		//		Lo estudiaremos más adelante
	    if (!$tarea) {
	        throw $this->createNotFoundException(sprintf('No se encontró ninguna tarea con el término: "%s"', $term));
	    }
	
	    // 3. Si existe, devolvemos la tarea encontrada
	    return $this->json($tarea);
	}
}
