<?php

namespace App\Core\Repository;

use App\Core\Entity\RepositoryInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RepositoryInformation>
 *
 * @method RepositoryInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepositoryInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepositoryInformation[]    findAll()
 * @method RepositoryInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepositoryInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepositoryInformation::class);
    }

    public function add(RepositoryInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RepositoryInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RepositoryInformation[] Returns an array of RepositoryInformation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RepositoryInformation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
