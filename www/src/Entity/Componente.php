<?php

namespace App\Entity;

use App\Repository\ComponenteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComponenteRepository::class)]
class Componente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $coste = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'componentes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tarea $tarea = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCoste(): ?int
    {
        return $this->coste;
    }

    public function setCoste(int $coste): static
    {
        $this->coste = $coste;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

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

    public function getTarea(): ?Tarea
    {
        return $this->tarea;
    }

    public function setTarea(?Tarea $tarea): static
    {
        $this->tarea = $tarea;

        return $this;
    }

    /**
     * Devuelve el coste formateado en euros para mostrar en la UI.
     * De esta forma, la logica de presentacion queda en la entidad,
     * no dispersa por las plantillas Twig.
     */
    public function getCosteFormateado(): string
    {
        return number_format($this->coste / 100, 2, ',', '.') . ' EUR';
    }

    /**
     * El coste total de este componente es precio unitario x cantidad.
     */
    public function getCosteTotal(): int
    {
        return $this->coste * $this->cantidad;
    }

    public function getCosteTotalFormateado(): string
    {
        return number_format($this->getCosteTotal() / 100, 2, ',', '.') . ' EUR';
    }
}
