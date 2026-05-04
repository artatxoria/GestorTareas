<?php

namespace App\Controller;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Service\GestionCentralService;

#[Route('/usuarios', requirements: ['id' => Requirement::DIGITS])]
class UsuarioController extends AbstractController
{
    /**
     * Listado general de todos los usuarios.
     */
    #[Route('', name: 'listado_usuarios')]
    public function index(UsuarioRepository $repository): Response
    {
        $usuarios = $repository->findAll();
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Detalle de un usuario específico filtrado por su ID.
     */
    #[Route('/{id}', name: 'usuario_show')]
    public function show(int $id, 
                        UsuarioRepository $repository,
                        GestionCentralService $gestionService): Response
    {
        $usuario = $repository->findById($id);
        if (!$usuario) {
            throw $this->createNotFoundException('El usuario no existe en nuestro registro.');
        }
        
        // NUEVO: Obtener las tareas del usuario usando el servicio
	    $tareasUsuario = $gestionService->findTareasByUsuario($usuario);
     
         
        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
	        'tareas' => $tareasUsuario,  // <- NUEVO: Pasar tareas a la plantilla
        ]);
    }

    /**
     * Usuarios filtrados por género.
     */
    #[Route('/genero/{genero}', name: 'usuario_filtro_genero')]
    public function filtroGenero(string $genero, UsuarioRepository $repository): Response
    {
        $usuarios = $repository->findByGenero($genero);
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }
}