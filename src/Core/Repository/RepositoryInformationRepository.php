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

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
