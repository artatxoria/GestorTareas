<?php

namespace App\Model;

class Usuario
{
    public function __construct(
        private int    $id,
        private string $nombre,
        private string $apellido,
        private string $email,
        private string $telefono,
        private string $ciudad,
        private string $comunidad,
        private string $dni,
        private int    $edad,
        private string $genero,
        private string $fotografia,
    ) {}

    public function getId(): int          { return $this->id; }
    public function getNombre(): string   { return $this->nombre; }
    public function getApellido(): string { return $this->apellido; }
    public function getEmail(): string    { return $this->email; }
    public function getTelefono(): string { return $this->telefono; }
    public function getCiudad(): string   { return $this->ciudad; }
    public function getComunidad(): string{ return $this->comunidad; }
    public function getDni(): string      { return $this->dni; }
    public function getEdad(): int        { return $this->edad; }
    public function getGenero(): string   { return $this->genero; }
    public function getFotografia(): string { return $this->fotografia; }

    public function getNombreCompleto(): string
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}