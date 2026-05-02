<?php

	namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Attribute\Route;
	use App\Repository\TareaRepository;
	
	class MainController extends AbstractController
	{
        #[Route('/', name: 'home')]
        public function homepage(TareaRepository $repository): Response
        {
            // Obtenemos todas las tareas desde nuestro servicio
	        $tareas = $repository->findAll();
			
			// Seleccionamos una tarea al azar para mostrarla como destacada
	        $tareaAzar = $tareas[array_rand($tareas)];
		
		  return $this->render('main/homepage.html.twig', [
	            // Pasamos la coleccion completa para contarla en Twig con |length
	            'tareas' => $tareas,
	            'tarea'  => $tareaAzar,
				'totalTareas' => count($tareas),
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