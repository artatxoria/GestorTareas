<?php

namespace App\Controller;

use App\Entity\Componente;
use App\Form\ComponenteType;
use App\Repository\ComponenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/componente')]
final class ComponenteController extends AbstractController
{
    #[Route(name: 'app_componente_index', methods: ['GET'])]
    public function index(ComponenteRepository $componenteRepository): Response
    {
        return $this->render('componente/index.html.twig', [
            'componentes' => $componenteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_componente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $componente = new Componente();
        $form = $this->createForm(ComponenteType::class, $componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($componente);
            $entityManager->flush();

            return $this->redirectToRoute('app_componente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('componente/new.html.twig', [
            'componente' => $componente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_componente_show', methods: ['GET'])]
    public function show(Componente $componente): Response
    {
        return $this->render('componente/show.html.twig', [
            'componente' => $componente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_componente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Componente $componente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComponenteType::class, $componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_componente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('componente/edit.html.twig', [
            'componente' => $componente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_componente_delete', methods: ['POST'])]
    public function delete(Request $request, Componente $componente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$componente->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($componente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_componente_index', [], Response::HTTP_SEE_OTHER);
    }
}
