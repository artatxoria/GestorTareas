<?php

namespace App\Repository;

use App\Model\Tarea;
use Psr\Log\LoggerInterface;
use App\Model\TareaEstadoEnum;
use App\Model\Usuario;
use App\Repository\UsuarioRepository;

class TareaRepository
{
    
    // Al añadir "private", PHP crea la propiedad y le asigna el valor automaticamente
    public function __construct(private UsuarioRepository $usuarioRepository, 
                                private LoggerInterface $logger)
    {
    }

    public function findAll(): array
    {
        $this->logger->info('Consultando la lista de tareas...');

        // Obtener usuarios para asignarlos como propietarios
        $usuarios = $this->usuarioRepository->findAll();

        // Si no hay usuarios, devolvemos array vacío
        if (empty($usuarios)) {
            $this->logger->warning('No hay usuarios disponibles en el repositorio.');
            return [];
        }

        // Función auxiliar para obtener usuario de forma segura
        $getUsuario = function(int $index) use ($usuarios) {
            // Si el índice existe, devolver ese usuario
            // Si no existe, devolver el primer usuario
            return $usuarios[$index] ?? $usuarios[0];
        };
    
        // En el futuro, aqui residira la logica de Doctrine (SQL).
        // Por ahora, "fabricamos" los datos manualmente para probar el flujo.
       return [
            new Tarea(1,  'Revisar informe trimestral',        'Preparar presentación para la reunión de dirección',           TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-10'), 1,$getUsuario(0)),
            new Tarea(2,  'Comprar material de oficina',       'Toner para impresoras y papel A4',                             TareaEstadoEnum::COMPLETADA,  new \DateTimeImmutable('2026-04-10'), 9,$getUsuario(1)),
            new Tarea(3,  'Actualizar documentación API',      'Revisar y completar los endpoints del proyecto',               TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-25'), 9,$getUsuario(2)),
            new Tarea(4,  'Llamar al proveedor de hosting',   'Negociar renovación del contrato anual',                       TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-08'), 7, $getUsuario(3)),
            new Tarea(5,  'Migrar base de datos a MySQL 8',   'Actualizar el servidor de producción antes del lanzamiento',   TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-15'), 10,$getUsuario(4)),
            new Tarea(6,  'Diseñar logo corporativo',          'Entregar tres propuestas al cliente para su validación',       TareaEstadoEnum::COMPLETADA,  new \DateTimeImmutable('2026-04-01'), 5,$getUsuario(5)),
            new Tarea(7,  'Redactar política de privacidad',  'Adaptarla al nuevo reglamento europeo de protección de datos', TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-06-01'), 8, $getUsuario(6)),
            new Tarea(8,  'Formación en Symfony 7',            'Completar el módulo de Doctrine y formularios',                TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-30'), 6,$getUsuario(7)),
            new Tarea(9,  'Auditoría de seguridad',            'Revisar permisos de usuarios y accesos al servidor',           TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-20'), 10, $getUsuario(8)),
            new Tarea(10, 'Actualizar dependencias Composer',  'Ejecutar composer update y revisar breaking changes',          TareaEstadoEnum::COMPLETADA,  new \DateTimeImmutable('2026-04-15'), 4, $getUsuario(9)),
            new Tarea(11, 'Crear tests unitarios',             'Cubrir al menos el 80% del código con PHPUnit',                TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-06-10'), 7, $getUsuario(0)),
            new Tarea(12, 'Revisar facturas de abril',         'Comprobar que todos los pagos están registrados correctamente', TareaEstadoEnum::COMPLETADA, new \DateTimeImmutable('2026-04-30'), 3, $getUsuario(1)),
            new Tarea(13, 'Implementar sistema de caché',      'Integrar Redis para mejorar el rendimiento de la aplicación',  TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-18'), 8, $getUsuario(2)),
            new Tarea(14, 'Preparar demo para el cliente',     'Montar entorno de staging con datos de prueba',                TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-12'), 9, $getUsuario(3)),
            new Tarea(15, 'Optimizar consultas SQL',           'Analizar el query log y añadir índices donde sea necesario',   TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-22'), 6, $getUsuario(4)),
            new Tarea(16, 'Configurar entorno Docker',         'Dockerizar la aplicación para facilitar el despliegue',        TareaEstadoEnum::COMPLETADA,  new \DateTimeImmutable('2026-04-20'), 5, $getUsuario(5)),
            new Tarea(17, 'Escribir newsletter mensual',       'Redactar contenido para los suscriptores de mayo',             TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-28'), 2, $getUsuario(6)),
            new Tarea(18, 'Revisar pull requests pendientes',  'Dar feedback a los tres PR abiertos en el repositorio',        TareaEstadoEnum::EN_PROGRESO, new \DateTimeImmutable('2026-05-06'), 7, $getUsuario(7)),
            new Tarea(19, 'Backup semanal del servidor',       'Verificar que el backup automatizado se ha ejecutado',         TareaEstadoEnum::COMPLETADA,  new \DateTimeImmutable('2026-04-28'), 1, $getUsuario(8)),
            new Tarea(20, 'Planificación sprint de junio',     'Definir objetivos y asignar tareas al equipo para el mes',     TareaEstadoEnum::PENDIENTE,   new \DateTimeImmutable('2026-05-31'), 8, $getUsuario(9)),
        ];
    }

    public function findTareaById(int $id): ?Tarea
    {
        $tareas = $this->findAll();
    
        foreach ($tareas as $tarea)
        {
            if ($tarea ->getId() === $id)
            {
                return $tarea;
            }
        }
        return null;
    }

    public function findByStatus(TareaEstadoEnum $status): array
	{
	    return array_filter($this->findAll(), fn($t) => $t->getEstado() === $status);
	}

    public function findByTerm(string $term): ?Tarea
	{
	    foreach ($this->findAll() as $tarea) {
	        if (false !== stripos($tarea->getTitulo(), $term)) {
	            return $tarea;
	        }
	    }
	    return null;
	}
}