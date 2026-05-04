<?php

namespace App\Service;

use App\Model\Tarea;
use App\Model\Usuario;
use App\Model\TareaEstadoEnum;
use App\Repository\TareaRepository;
use App\Repository\UsuarioRepository;

class GestionCentralService
{
    public function __construct(
        private TareaRepository $tareaRepository,
        private UsuarioRepository $usuarioRepository
    ) {}

    /**
     * Obtiene las tareas de un usuario específico.
     * 
     * Este es el método clave que implementa la relación entre Tarea y Usuario.
     * Ejemplo de lógica de negocio que añade valor real.
     */
    public function findTareasByUsuario(Usuario $usuario): array
    {
        $todasTareas = $this->tareaRepository->findAll();
        
        return array_filter(
            $todasTareas,
            fn(Tarea $tarea) => $tarea->getPropietario()->getId() === $usuario->getId()
        );
    }

    /**
     * Obtiene estadísticas del sistema.
     * 
     * Ejemplo de lógica de negocio centralizada que coordina múltiples repositorios.
     */
    public function getEstadisticas(): array
    {
        $usuarios = $this->usuarioRepository->findAll();
        $tareas = $this->tareaRepository->findAll();
        
        $estadisticas = [
            'total_usuarios' => count($usuarios),
            'total_tareas' => count($tareas),
            'tareas_por_estado' => [],
            'usuarios_por_genero' => [],
        ];
        
        // Contar tareas por estado
        foreach (TareaEstadoEnum::cases() as $estado) {
            $tareasEstado = array_filter(
                $tareas,
                fn(Tarea $tarea) => $tarea->getEstado() === $estado
            );
            $estadisticas['tareas_por_estado'][$estado->value] = count($tareasEstado);
        }
        
        // Contar usuarios por género
        $generos = ['male', 'female'];
        foreach ($generos as $genero) {
            $usuariosGenero = array_filter(
                $usuarios,
                fn(Usuario $usuario) => $usuario->getGenero() === $genero
            );
            $estadisticas['usuarios_por_genero'][$genero] = count($usuariosGenero);
        }
        
        return $estadisticas;
    }

    /**
     * Obtiene las tareas urgentes (prioridad >= 8) de un usuario específico.
     * 
     * Ejemplo de lógica de negocio compleja que combina:
     * 1. Relación usuario-tarea
     * 2. Filtrado por prioridad
     */
    public function findTareasUrgentesByUsuario(Usuario $usuario): array
    {
        $tareasUsuario = $this->findTareasByUsuario($usuario);
        
        return array_filter(
            $tareasUsuario,
            fn(Tarea $tarea) => $tarea->getPrioridad() >= 8
        );
    }

    /**
     * Obtiene el usuario con más tareas asignadas.
     * 
     * Ejemplo de lógica de negocio que analiza relaciones.
     */
    public function getUsuarioMasOcupado(): ?Usuario
    {
        $usuarios = $this->usuarioRepository->findAll();
        $tareas = $this->tareaRepository->findAll();
        
        if (empty($usuarios) || empty($tareas)) {
            return null;
        }
        
        $conteoTareasPorUsuario = [];
        
        foreach ($tareas as $tarea) {
            $usuarioId = $tarea->getPropietario()->getId();
            $conteoTareasPorUsuario[$usuarioId] = ($conteoTareasPorUsuario[$usuarioId] ?? 0) + 1;
        }
        
        if (empty($conteoTareasPorUsuario)) {
            return null;
        }
        
        $usuarioIdMasOcupado = array_keys($conteoTareasPorUsuario, max($conteoTareasPorUsuario))[0];
        
        return $this->usuarioRepository->findById($usuarioIdMasOcupado);
    }

    /**
     * Obtiene tareas que vencen pronto (en los próximos 7 días).
     * 
     * Ejemplo de lógica de negocio con fecha.
     */
    public function findTareasPorVencer(): array
    {
        $tareas = $this->tareaRepository->findAll();
        $hoy = new \DateTimeImmutable();
        $limite = $hoy->modify('+7 days');
        
        return array_filter(
            $tareas,
            fn(Tarea $tarea) => $tarea->getFechaLimite() > $hoy && $tarea->getFechaLimite() <= $limite
        );
    }

    /**
     * Obtiene tareas atrasadas (fecha límite pasada y no completadas).
     * 
     * Ejemplo de lógica de negocio que combina estado y fecha.
     */
    public function findTareasAtrasadas(): array
    {
        $tareas = $this->tareaRepository->findAll();
        $hoy = new \DateTimeImmutable();
        
        return array_filter(
            $tareas,
            fn(Tarea $tarea) => 
                $tarea->getFechaLimite() < $hoy && 
                $tarea->getEstado() !== TareaEstadoEnum::COMPLETADA
        );
    }

    /**
     * Obtiene el resumen de carga de trabajo por usuario.
     * 
     * Ejemplo de lógica de negocio que genera un reporte estructurado.
     */
    public function getResumenCargaTrabajo(): array
    {
        $usuarios = $this->usuarioRepository->findAll();
        $resumen = [];
        
        foreach ($usuarios as $usuario) {
            $tareasUsuario = $this->findTareasByUsuario($usuario);
            $tareasUrgentes = $this->findTareasUrgentesByUsuario($usuario);
            $tareasAtrasadas = array_filter(
                $tareasUsuario,
                fn(Tarea $tarea) => 
                    $tarea->getFechaLimite() < new \DateTimeImmutable() && 
                    $tarea->getEstado() !== TareaEstadoEnum::COMPLETADA
            );
            
            $resumen[] = [
                'usuario' => $usuario,
                'total_tareas' => count($tareasUsuario),
                'tareas_urgentes' => count($tareasUrgentes),
                'tareas_atrasadas' => count($tareasAtrasadas),
                'tareas_completadas' => count(array_filter(
                    $tareasUsuario,
                    fn(Tarea $tarea) => $tarea->getEstado() === TareaEstadoEnum::COMPLETADA
                )),
            ];
        }
        
        return $resumen;
    }
}