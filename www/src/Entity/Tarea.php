<?php

namespace App\Entity;

use App\Repository\TareaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\TareaEstadoEnum;

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

    #[ORM\Column(enumType: TareaEstadoEnum::class)]
    private ?TareaEstadoEnum $estado = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaLimite = null;

    #[ORM\Column]
    private ?int $prioridad = null;

    #[ORM\ManyToOne(inversedBy: 'tareas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $propietario = null;

    /**
     * @var Collection<int, Componente>
     */
    #[ORM\OneToMany(targetEntity: Componente::class, mappedBy: 'tarea')]
    private Collection $componentes;

    public function __construct()
    {
        $this->componentes = new ArrayCollection();
    }

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

    public function getEstado(): ?TareaEstadoEnum
    {
        return $this->estado;
    }

    public function setEstado(TareaEstadoEnum $estado): static
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

    /**
     * @return Collection<int, Componente>
     */
    public function getComponentes(): Collection
    {
        return $this->componentes;
    }

    public function addComponente(Componente $componente): static
    {
        if (!$this->componentes->contains($componente)) {
            $this->componentes->add($componente);
            $componente->setTarea($this);
        }

        return $this;
    }

    public function removeComponente(Componente $componente): static
    {
        if ($this->componentes->removeElement($componente)) {
            // set the owning side to null (unless already changed)
            if ($componente->getTarea() === $this) {
                $componente->setTarea(null);
            }
        }

        return $this;
    }
}
