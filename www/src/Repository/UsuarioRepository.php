<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Usuario>
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * Devuelve todos los usuarios con el numero de tareas de cada uno.
     * Usamos una consulta DQL con COUNT para calcular esto eficientemente
     * en la propia base de datos, sin cargar todas las tareas en memoria.
     *
     * @return array Array de [usuario, numTareas]
     */
    public function findAllConContadorTareas(): array
    {
        return $this->createQueryBuilder('u')
            ->addSelect('COUNT(t.id) AS numTareas')
            ->leftJoin('u.tareas', 't')
            ->groupBy('u.id')
            ->orderBy('u.apellido', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Busca usuarios cuyo nombre o apellido contenga el termino de busqueda.
     * Usamos LIKE para la busqueda parcial, con parametros para evitar
     * inyeccion SQL (nunca concatenes strings directamente en DQL).
     *
     * @return Usuario[]
     */
    public function findByNombreOApellido(string $termino): array
    {
        $termino = '%' . $termino . '%';

        return $this->createQueryBuilder('u')
            ->where('u.nombre LIKE :termino')
            ->orWhere('u.apellido LIKE :termino')
            ->setParameter('termino', $termino)
            ->orderBy('u.apellido', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Devuelve los usuarios que tienen al menos una tarea en progreso,
     * junto con esas tareas precargadas.
     *
     * @return Usuario[]
     */
    public function findConTareasEnProgreso(): array
    {
        return $this->createQueryBuilder('u')
            ->addSelect('t')
            ->join('u.tareas', 't')
            ->where("t.estado = 'en progreso'")
            ->orderBy('u.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}