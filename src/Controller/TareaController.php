<?php

namespace App\Controller;

use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/tareas', requirements: ['id' => Requirement::DIGITS])]
class TareaController extends AbstractController
{
    /**
     * Listado general de todas las tareas.
     */
    #[Route('', name:'listado_tareas')]
    public function index(TareaRepository $repository): Response
    {
        // Obtenemos todas las tareas a traves del repositorio
        $tareas = $repository->findAll();

        return $this->render('tarea/index.html.twig', [
            'tareas' => $tareas,
        ]);
    }

    /**
     * Detalle de una tarea especifica filtrada por su ID.
     */
    #[Route('/{id}', name: 'tarea_show')]
    public function show(int $id, TareaRepository $repository): Response
    {
        // Usamos el metodo especializado de nuestro repositorio
        $tarea = $repository->findTareaById($id);

        if (!$tarea) {
            throw $this->createNotFoundException('La tarea no existe en nuestro registro.');
        }

        return $this->render('tarea/show.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    #[Route('/estado/{status}', name: 'tarea_filtro_estado')]
    public function tarea_filtro_estado(string $status, TareaRepository $repository): Response
    {
        // Obtenemos todas las tareas a traves del repositorio
        $tareas = $repository->findByStatus($status);

        return $this->render('tarea/index.html.twig', [
            'tareas' => $tareas,
        ]);
    }

}