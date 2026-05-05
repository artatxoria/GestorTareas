<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // <--- ESTA ES LA QUE TE FALTA
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

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
    public function show(int $id, UsuarioRepository $repository): Response
    {
        $usuario = $repository->find($id);
        if (!$usuario) {
            throw $this->createNotFoundException('El usuario no existe en nuestro registro.');
        }

        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
            'tareas' => $usuario->getTareas(),
        ]);
    }

    /**
     * Usuarios filtrados por género.
     */
    #[Route('/genero/{genero}', name: 'usuario_filtro_genero')]
    public function filtroGenero(string $genero, UsuarioRepository $repository): Response
    {
        $usuarios = $repository->findBy(['genero' => $genero]);
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Nuevo usuario
     */
    #[Route('/new', name: 'usuario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($usuario);
            $entityManager->flush();
            $this->addFlash('success', '¡Usuario creado con éxito!');
            return $this->redirectToRoute('listado_usuarios');
        }

        return $this->render('usuario/new.html.twig', [
            'form' => $form,
        ]);
    }
}