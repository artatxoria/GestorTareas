<?php

namespace App\Repository;

use App\Entity\Tarea;
use App\Enum\TareaEstadoEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tarea>
 */
class TareaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarea::class);
    }

    /**
     * Devuelve todas las tareas con sus propietarios y componentes
     * precargados en UNA SOLA consulta SQL usando JOIN FETCH.
     * Esto evita el problema N+1.
     *
     * @return Tarea[]
     */
    public function findAllConRelaciones(): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('u')           // Precarga el propietario (Usuario)
            ->addSelect('c')           // Precarga los componentes
            ->join('t.propietario', 'u')
            ->leftJoin('t.componentes', 'c')
            ->orderBy('t.prioridad', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Busca las tareas de un usuario concreto, ordenadas por prioridad.
     * Tambien precarga los componentes.
     *
     * @return Tarea[]
     */
    public function findByPropietario(int $usuarioId): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('c')
            ->leftJoin('t.componentes', 'c')
            ->where('t.propietario = :id')
            ->setParameter('id', $usuarioId)
            ->orderBy('t.prioridad', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Busca tareas por estado, precargando propietario y componentes.
     *
     * @return Tarea[]
     */
    public function findByEstado(TareaEstadoEnum $estado): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('u', 'c')
            ->join('t.propietario', 'u')
            ->leftJoin('t.componentes', 'c')
            ->where('t.estado = :estado')
            ->setParameter('estado', $estado->value)
            ->orderBy('t.fechaLimite', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Devuelve las tareas cuya fecha limite esta proxima (en los 
     * proximos $dias dias) y que no estan completadas.
     *
     * @return Tarea[]
     */
    public function findProximasAVencer(int $dias = 7): array
    {
        $ahora     = new \DateTimeImmutable('now');
        $limite    = new \DateTimeImmutable("+{$dias} days");

        return $this->createQueryBuilder('t')
            ->addSelect('u', 'c')
            ->join('t.propietario', 'u')
            ->leftJoin('t.componentes', 'c')
            ->where('t.fechaLimite BETWEEN :ahora AND :limite')
            ->andWhere('t.estado != :completada')
            ->setParameter('ahora', $ahora)
            ->setParameter('limite', $limite)
            ->setParameter('completada', TareaEstadoEnum::COMPLETADA->value)
            ->orderBy('t.fechaLimite', 'ASC')
            ->getQuery()
            ->getResult();
    }
}