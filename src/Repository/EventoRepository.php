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
            ->orderBy('e.id', 'DESC')
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
        if (!is_null($clave)) $query->andWhere('e.descripcion LIKE :clave OR e.titulo LIKE :clave')->setParameter('clave', '%' . $clave . '%');
        if ($categoriaID != 0) $query->andWhere('e.categoria = :categoria')->setParameter('categoria', $categoriaID);
        if (!is_null($inicio)) $query->andWhere('e.fechaFin >= :inicio OR e.fechaInicio >= :inicio')->setParameter('inicio', $inicio);
        if (!is_null($fin)) $query->andWhere('e.fechaFin <= :fin OR e.fechaInicio <= :fin')->setParameter('fin', $fin);
        if ($gratis) $query->andWhere('e.precio = 0');
        $query->andWhere('e.bloqueado = 0')->andWhere('e.visible = 1');
        $result = $query->addOrderBy('e.fechaInicio', 'ASC')->addOrderBy('e.hora','ASC')->getQuery()->getResult();

        return $result;
    }
}
