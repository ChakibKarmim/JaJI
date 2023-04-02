<?php

namespace App\Repository;

use App\Entity\Chapters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chapters>
 *
 * @method Chapters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chapters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chapters[]    findAll()
 * @method Chapters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChaptersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chapters::class);
    }

    public function save(Chapters $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chapters $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Chapters[] Returns an array of Chapters objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Chapters
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @throws NonUniqueResultException
     */
    public function getLightInfo($chapter_id)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id','c.title','c.chapter_order')
            ->andWhere('c.id = :chapter_id')
            ->setParameter('chapter_id', $chapter_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findPrevChapter($formation, $order)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id','c.title','c.chapter_order')
            ->andWhere('c.formation_id = :formation')
            ->andWhere('c.chapter_order = :order')
            ->setParameter('formation', $formation)
            ->setParameter('order',$order)
            ->getQuery()
            ->getResult()
            ;
    }
}
