<?php

	namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Attribute\Route;
	
	class MainController extends AbstractController
	{
        #[Route('/', name: 'home')]
        public function homepage(): Response
        {
            $totalTareas = 457;   // Valor ficticio por ahora
		
		    $tareaEjemplo = [
                'titulo' => 'Revisar informe trimestral',
                'prioridad' => 'alta',
                'estado' => 'pendiente',
                'fechaLimite' => '2026-05-15',
            ];
                
            return $this->render('main/homepage.html.twig', [
                'totalTareas' => $totalTareas,
                'tarea' => $tareaEjemplo,
            ]);
        }

        #[Route('/sobre-mi', name: 'about')]
		public function about(): Response
		{
			return $this->render('main/about.html.twig');
		}
		
		#[Route('/servicios', name: 'services')]
		public function services(): Response
		{
			return $this->render('main/services.html.twig');
		}
		
		#[Route('/contacto', name: 'contact')]
		public function contact(): Response
		{
			return $this->render('main/contact.html.twig');
		}

	}