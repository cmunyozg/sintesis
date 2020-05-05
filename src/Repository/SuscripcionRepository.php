<?php

namespace App\Repository;

use App\Entity\Suscripcion;
use App\Entity\Usuario;
use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Suscripcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suscripcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suscripcion[]    findAll()
 * @method Suscripcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuscripcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suscripcion::class);
    }

    /**
     * @return Suscripcion[] 
     */
    public function findByUserAndEvent(Usuario $usuario, Evento $evento)
    {
        return $this->createQueryBuilder('s')
            ->where('s.evento = :evento')
            ->andWhere('s.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getResult();
    }

       /**
     * @return Suscripcion[] 
     */
    public function findByUser(Usuario $usuario)
    {
        return $this->createQueryBuilder('s')
            ->where('s.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Suscripcion[] Returns an array of Suscripcion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Suscripcion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
