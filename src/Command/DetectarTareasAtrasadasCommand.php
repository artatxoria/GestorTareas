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
use App\Repository\TareaRepository;
use App\Model\TareaEstadoEnum;
use App\Model\Tarea;

#[AsCommand(
    name: 'app:detectar-atrasadas',
    description: 'Detecta y reporta las tareas con fecha vencida',
)]
class DetectarTareasAtrasadasCommand extends Command
{
    public function __construct(
        private GestionCentralService $gestionService,
        private TareaRepository $tareaRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Detector de Tareas Atrasadas');

        $todasTareas = $this->tareaRepository->findAll();
        $total = count($todasTareas);

        $io->text("Analizando {$total} tareas...");
        $io->progressStart($total);

        $atrasadas = [];
        foreach ($todasTareas as $tarea) {
            $io->progressAdvance();
            // Usamos la logica de negocio del servicio central
            if ($tarea->getFechaLimite() < new \DateTimeImmutable()
                && $tarea->getEstado() !== TareaEstadoEnum::COMPLETADA) {
                $atrasadas[] = $tarea;
            }
        }

        $io->progressFinish();

        if (empty($atrasadas)) {
            $io->success('No hay tareas atrasadas. ¡Todo al día!');
            return Command::SUCCESS;
        }

        $io->warning(count($atrasadas) . ' tareas están atrasadas:');

        $filas = array_map(fn(Tarea $t) => [
            $t->getId(),
            $t->getTitulo(),
            $t->getPropietario()->getNombre(),
            $t->getFechaLimite()->format('d/m/Y'),
        ], $atrasadas);

        $io->table(
            ['ID', 'Título', 'Propietario', 'Fecha límite'],
            $filas
        );

        return Command::FAILURE; // Indica que hay tareas problemáticas
    }
}