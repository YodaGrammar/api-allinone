<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Challenge;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Paginator\QueryPaginator;
use App\RequestDto\QueryParamRequestDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

/**
 * @extends  ServiceEntityRepository<Challenge>
 */
class ChallengeRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Challenge::class);
    }

    /**
     * @return Challenge[]
     */
    public function findAllByFilter(QueryParamRequestDto $queryParam, User $user): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
                        ->andWhere('c.user = :user')
                        ->andWhere('c.deleted = false')
                        ->setParameter('user', $user->id->toRfc4122());

        return QueryPaginator::paginate($queryBuilder, $queryParam);
    }

    public function findOneById(Ulid $challengeId, User $user): Challenge
    {
        $challenge = $this->findOneBy(
            [
                'deleted' => false,
                'id' => $challengeId->toRfc4122(),
                'user' => $user->id->toRfc4122(),
            ]
        );

        if (false === $challenge instanceof Challenge) {
            throw new NotFoundException('Challenge not found');
        }

        return $challenge;
    }
}
