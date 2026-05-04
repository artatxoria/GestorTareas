<?php
	
namespace App\Model;

use App\Model\TareaEstadoEnum;
use App\Model\Usuario;

class Tarea
{
	public function __construct(
		private int $id,
		private string $titulo,
		private string $descripcion,
		private TareaEstadoEnum $estado,
		private \DateTimeImmutable $fechaLimite,
		private int $prioridad,
		private Usuario $propietario
	) {}

	// Getters generados automáticamente
	public function getId(): int { return $this->id; }
	public function getTitulo(): string { return $this->titulo; }
	public function getDescripcion(): string { return $this->descripcion; }
	public function getEstado(): TareaEstadoEnum { return $this->estado; }
	public function getFechaLimite(): \DateTimeImmutable { return $this->fechaLimite; }
	public function getPrioridad(): int { return $this->prioridad; }
	public function getPropietario(): Usuario { return $this->propietario; }
}