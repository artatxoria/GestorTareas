<?php

namespace App\Controller;

use App\Enum\TareaEstadoEnum;
use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TareaType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tarea;

#[Route('/tareas', requirements: ['id' => Requirement::DIGITS])]
class TareaController extends AbstractController
{
    /**
     * Listado general de todas las tareas.
     * Usamos findAllConRelaciones() para evitar el problema N+1:
     * una sola consulta SQL trae tareas, propietarios y componentes.
     */
    #[Route('', name: 'listado_tareas')]
    public function index(TareaRepository $repository): Response
    {
        $tareas = $repository->findAllConRelaciones();

        return $this->render('tarea/index.html.twig', [
            'tareas' => $tareas,
        ]);
    }

    /**
     * Detalle de una tarea específica filtrada por su ID.
     */
    #[Route('/{id}', name: 'tarea_show')]
    public function show(int $id, TareaRepository $repository): Response
    {
        $tarea = $repository->find($id);

        if (!$tarea) {
            throw $this->createNotFoundException('La tarea no existe en nuestro registro.');
        }

        return $this->render('tarea/show.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * Filtra las tareas por estado (pendiente, en progreso, completada).
     * Usamos findByEstado() del repositorio, que precarga propietario
     * y componentes y ordena por fechaLimite ascendente.
     */
    #[Route('/estado/{status}', name: 'tarea_filtro_estado')]
    public function tarea_filtro_estado(string $status, TareaRepository $repository): Response
    {
        $estadoEnum = TareaEstadoEnum::from($status);
        $tareas = $repository->findByEstado($estadoEnum);

        return $this->render('tarea/index.html.twig', [
            'tareas' => $tareas,
        ]);
    }

    /**
     * Formulario de creación de nueva tarea.
     */
    #[Route('/new', name: 'tarea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response 
    {
        $tarea = new Tarea();
        $form = $this->createForm(TareaType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tarea);
            $em->flush();
            $this->addFlash('success', 'Tarea creada con éxito');
            return $this->redirectToRoute('listado_tareas');
        }
        return $this->render('tarea/new.html.twig', ['form' => $form]);
    }
}