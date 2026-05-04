<?php
	
	namespace App\Command;
	
	use Symfony\Component\Console\Attribute\AsCommand;
	use Symfony\Component\Console\Command\Command;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Input\InputOption;
	use Symfony\Component\Console\Output\OutputInterface;
	use Symfony\Component\Console\Style\SymfonyStyle;
	use App\Service\GestionCentralService;
	use App\Repository\UsuarioRepository;
	use App\Model\Tarea;
	
	#[AsCommand(
	    name: 'app:informe-tareas',
	    description: 'Muestra un informe completo de tareas por usuario',
	)]
	class InformeTareasCommand extends Command
	{
	    public function __construct(
	        private GestionCentralService $gestionService,
	        private UsuarioRepository $usuarioRepository
	    ) {
	        parent::__construct();
	    }
	
	    protected function execute(InputInterface $input, OutputInterface $output): int
	    {
	        $io = new SymfonyStyle($input, $output);
			$io->title('Informe de Tareas - Gestor de Tareas');

	
	        $usuarios = $this->usuarioRepository->findAll();
	        $estadisticas = $this->gestionService->getEstadisticas();
	
	        // Resumen global
	        $io->section('Resumen Global');
	        $io->listing([
	            'Total de usuarios: ' . $estadisticas['total_usuarios'],
	            'Total de tareas: ' . $estadisticas['total_tareas'],
	        ]);
	
	        // Detalle por usuario
	        $io->section('Informe de Tareas por usuario');
	
	        $nombres = array_map(
	            fn($usuario) => $usuario->getNombre() . ' ' . $usuario->getApellido(),
	            $usuarios
	        );
	        $io->listing($nombres);
	
	        // Tabla detallada
	        $io->section('Detalle por Usuario');
	
	        foreach ($usuarios as $usuario) {
	            $tareas = $this->gestionService->findTareasByUsuario($usuario);
	            $io->text("<info>{$usuario->getNombre()} {$usuario->getApellido()}</info>");
	
	            if (empty($tareas)) {
	                $io->note('Sin tareas asignadas.');
	                continue;
	            }
	
	            $filas = array_map(fn(Tarea $t) => [
	                $t->getId(),
	                $t->getTitulo(),
	                $t->getEstado()->getTextoLegible(),
	                $t->getFechaLimite()->format('d/m/Y'),
	                'P' . $t->getPrioridad() . '/10',
	            ], $tareas);
	
	            $io->table(
	                ['ID', 'Título', 'Estado', 'Fecha límite', 'Prioridad'],
	                $filas
	            );
	        }
	
	        $io->success('Informe generado correctamente.');
	        return Command::SUCCESS;
	    }
	}