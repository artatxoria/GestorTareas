<?php

namespace App\Enum;

/**
 * Enum para gestionar los estados de una tarea.
 * Usamos un Backed Enum de tipo string para facilitar
 * la persistencia y la lectura en las plantillas.
 */
enum TareaEstadoEnum: string
{
    case PENDIENTE = 'pendiente';
    case EN_PROGRESO = 'en progreso';
    case COMPLETADA = 'completada';

    /**
     * Devuelve la clase de color de Tailwind CSS asociada
     * a cada estado para centralizar el diseño.
     */
    public function getLabelColor(): string
    {
        return match($this) {
            self::PENDIENTE   => 'bg-amber-100 text-amber-700',
            self::EN_PROGRESO => 'bg-blue-100 text-blue-700',
            self::COMPLETADA  => 'bg-green-100 text-green-700',
        };
    }

    /**
	 * Devuelve una descripcion amigable para el usuario final.
	 * Esto separa el valor tecnico (db) de la capa de presentacion (UI).
	 */
	public function getTextoLegible(): string
	{
	    return match($this) {
	        self::PENDIENTE   => 'A la espera de comenzar',
	        self::EN_PROGRESO => 'Trabajando en ello actualmente',
	        self::COMPLETADA  => 'Tarea finalizada con exito',
	    };
	}

    // En  (ESTO ES LO IDEAL)
	public function getIcono(): string
	{
	    return match($this) {
	        self::PENDIENTE   => 'bi-clock',
	        self::EN_PROGRESO => 'bi-gear-wide-connected',
	        self::COMPLETADA  => 'bi-check-circle',
	    };
	}

}