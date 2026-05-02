<?php
	
namespace App\Model;

class Tarea
{
	public function __construct(
		private int $id,
		private string $titulo,
		private string $descripcion,
		private string $estado,
		private \DateTimeImmutable $fechaLimite,
		private int $prioridad,
	) {}

	// Getters generados automáticamente
	public function getId(): int { return $this->id; }
	public function getTitulo(): string { return $this->titulo; }
	public function getDescripcion(): string { return $this->descripcion; }
	public function getEstado(): string { return $this->estado; }
	public function getFechaLimite(): \DateTimeImmutable { return $this->fechaLimite; }
	public function getPrioridad(): int { return $this->prioridad; }
}