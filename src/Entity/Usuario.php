<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $apellido = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $telefono = null;

    #[ORM\Column(length: 100)]
    private ?string $ciudad = null;

    #[ORM\Column(length: 100)]
    private ?string $comunidad = null;

    #[ORM\Column(length: 10)]
    private ?string $dni = null;

    #[ORM\Column(length: 10)]
    private ?string $genero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fotografia = null;

    /**
     * @var Collection<int, Tarea>
     */
    #[ORM\OneToMany(targetEntity: Tarea::class, mappedBy: 'propietario')]
    private Collection $tareas;

    public function __construct()
    {
        $this->tareas = new ArrayCollection();
    }

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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getComunidad(): ?string
    {
        return $this->comunidad;
    }

    public function setComunidad(string $comunidad): static
    {
        $this->comunidad = $comunidad;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getFotografia(): ?string
    {
        return $this->fotografia;
    }

    public function setFotografia(?string $fotografia): static
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * @return Collection<int, Tarea>
     */
    public function getTareas(): Collection
    {
        return $this->tareas;
    }

    public function addTarea(Tarea $tarea): static
    {
        if (!$this->tareas->contains($tarea)) {
            $this->tareas->add($tarea);
            $tarea->setPropietario($this);
        }

        return $this;
    }

    public function removeTarea(Tarea $tarea): static
    {
        if ($this->tareas->removeElement($tarea)) {
            // set the owning side to null (unless already changed)
            if ($tarea->getPropietario() === $this) {
                $tarea->setPropietario(null);
            }
        }

        return $this;
    }
}
