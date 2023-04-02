<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lesson>
 *
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function save(Lesson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lesson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Lesson[] Returns an array of Lesson objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findLessonsLightByChapter($chapter_id): array
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('l.id', 'l.title', 'l.lesson_order')
            ->andWhere('l.chapter_id = :chap_id')
            ->setParameter('chap_id', $chapter_id);

        return $qb->getQuery()->getResult();
    }


    /**
     * @throws NonUniqueResultException
     */
    public function getNextPrevLesson($chapter_id, $order)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('l.id,l.title,l.lesson_order')
            ->andWhere('l.chapter_id = :chap_id')
            ->andWhere('l.lesson_order =:order')
            ->setParameter('order',$order)
            ->setParameter('chap_id',$chapter_id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
