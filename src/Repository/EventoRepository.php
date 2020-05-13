<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Evento;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    /**
     * @return Evento[] Returns an array of Evento objects
     */
    public function findByUsuario(Usuario $usuario)
    {
        return $this->createQueryBuilder('e')
            ->where('e.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('e.fechaInicio', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Evento[] Returns an array of Evento objects
     */
    public function findByCategoria($categoriaID)
    {
        return $this->createQueryBuilder('e')
            ->where('e.categoria = :categoria')
            ->setParameter('categoria', $categoriaID)
            ->orderBy('e.fechaInicio', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Evento[] Returns an array of Evento objects
     */
    public function findEvents($clave, $categoriaID, $inicio, $fin, $gratis)
    {
        $query = $this->createQueryBuilder('e');
        if (!is_null($categoriaID)) $query->where('e.categoria = :categoria')
            ->setParameter('categoria', $categoriaID)->getQuery()->getResult();
        return $query;
    }
}
