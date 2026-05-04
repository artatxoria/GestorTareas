<?php

namespace App\Entity;

use App\Repository\TareaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Model\TareaEstadoEnum;

#[ORM\Entity(repositoryClass: TareaRepository::class)]
class Tarea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 50)]
    private ?TareaEstadoEnum $estado = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column]
    private ?int $prioridad = null;

    #[ORM\ManyToOne(inversedBy: 'tareas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $propietario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFechaLimite(): ?\DateTimeImmutable
    {
        return $this->fechaLimite;
    }

    public function setFechaLimite(\DateTimeImmutable $fechaLimite): static
    {
        $this->fechaLimite = $fechaLimite;

        return $this;
    }

    public function getPrioridad(): ?int
    {
        return $this->prioridad;
    }

    public function setPrioridad(int $prioridad): static
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    public function getPropietario(): ?Usuario
    {
        return $this->propietario;
    }

    public function setPropietario(?Usuario $propietario): static
    {
        $this->propietario = $propietario;

        return $this;
    }
}
