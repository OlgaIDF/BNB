<?php

namespace App\Repository;

use App\Entity\Maisons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maisons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maisons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maisons[]    findAll()
 * @method Maisons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaisonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maisons::class);
    }

    // /**
    //  * @return Maisons[] Returns an array of Maisons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Maisons
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSix() /* pour ne sélectionner que 6 maisons */
    {
        return $this->createQueryBuilder('s') /* 's' est un alias */
            ->andWhere('s.id > :val') /* on cherhce un id supérieur à une valeur */
            ->setParameter('val', '0') /* on donne la valeur */
            ->orderBy('s.id', 'DESC') /* tri en ordre décroissant */
            ->setMaxResults(6) /* on sélectionne 6 résultats maximum */
            ->getQuery() /* requête */
            ->getResult() /* résultats */
        ;
    }

    public function findByMinSize($superficieMini) /* pour sélectionner par superficie */
    {
        return $this->createQueryBuilder('ms')
            ->andWhere('ms.superficie < :val') /* on cherche une superficie < une valeur */
            ->setParameter('val', $superficieMini) /* on définit cette valeur*/
            ->orderBy('ms.superficie', 'DESC') /* tri en ordre décroissant */
            ->getQuery() /* requête */
            ->getResult() /* résultats */
        ;
    }
}
