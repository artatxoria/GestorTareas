<?php

namespace App\Repository;

use App\Model\Usuario;

class UsuarioRepository
{
    public function findAll(): array
    {
        return [
            new Usuario(1,  'Mohamed',      'Muñoz',    'mohamed.munoz@example.com',      '950-688-850', 'Sevilla',                  'Islas Baleares',        '00375700-F', 39, 'male',   'https://randomuser.me/api/portraits/men/74.jpg'),
            new Usuario(2,  'Juana',        'León',     'juana.leon@example.com',          '940-162-698', 'Pamplona',                 'Ceuta',                 '70269333-F', 54, 'female', 'https://randomuser.me/api/portraits/women/67.jpg'),
            new Usuario(3,  'Eva',          'Bravo',    'eva.bravo@example.com',           '969-849-230', 'Alicante',                 'Región de Murcia',      '32309284-W', 73, 'female', 'https://randomuser.me/api/portraits/women/9.jpg'),
            new Usuario(4,  'Teresa',       'Delgado',  'teresa.delgado@example.com',      '992-831-754', 'Hospitalet de Llobregat',  'Comunidad de Madrid',   '00481693-F', 37, 'female', 'https://randomuser.me/api/portraits/women/30.jpg'),
            new Usuario(5,  'Gustavo',      'Castro',   'gustavo.castro@example.com',      '901-092-327', 'Hospitalet de Llobregat',  'Castilla y León',       '71465136-N', 38, 'male',   'https://randomuser.me/api/portraits/men/9.jpg'),
            new Usuario(6,  'Alex',         'Ramírez',  'alex.ramirez@example.com',        '944-394-738', 'Fuenlabrada',              'Navarra',               '00988866-Q', 73, 'male',   'https://randomuser.me/api/portraits/men/90.jpg'),
            new Usuario(7,  'Encarnación',  'Mora',     'encarnacion.mora@example.com',    '973-196-480', 'La Palma',                 'Castilla y León',       '62538757-W', 60, 'female', 'https://randomuser.me/api/portraits/women/16.jpg'),
            new Usuario(8,  'Lucas',        'Carmona',  'lucas.carmona@example.com',       '907-473-976', 'Ciudad Real',              'Andalucía',             '24049769-P', 33, 'male',   'https://randomuser.me/api/portraits/men/74.jpg'),
            new Usuario(9,  'Alfredo',      'Herrera',  'alfredo.herrera@example.com',     '939-377-239', 'Cuenca',                   'Canarias',              '58405293-P', 60, 'male',   'https://randomuser.me/api/portraits/men/71.jpg'),
            new Usuario(10, 'David',        'Rubio',    'david.rubio@example.com',         '923-976-672', 'Alcalá de Henares',        'Comunidad Valenciana',  '25196824-I', 64, 'male',   'https://randomuser.me/api/portraits/men/74.jpg'),
        ];
    }

    public function findById(int $id): ?Usuario
    {
        foreach ($this->findAll() as $usuario) {
            if ($usuario->getId() === $id) {
                return $usuario;
            }
        }
        return null;
    }

    public function findByGenero(string $genero): array
    {
        return array_filter(
            $this->findAll(),
            fn($u) => $u->getGenero() === $genero
        );
    }
}