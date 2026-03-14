<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Challenge;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Paginator\QueryPaginator;
use App\RequestDto\QueryParamRequestDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

/**
 * @extends  ServiceEntityRepository<Activity>
 */
class ActivityRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * @return Challenge[]
     */
    public function findAllByFilter(QueryParamRequestDto $queryParam, User $user): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
                        ->andWhere('a.user = :user')
                        ->andWhere('a.deleted = false')
                        ->setParameter('user', $user->id->toRfc4122());

        return QueryPaginator::paginate($queryBuilder, $queryParam);
    }

    public function findOneById(Ulid $activityId, User $user): Activity
    {
        $activity = $this->findOneBy(
            [
                'deleted' => false,
                'id' => $activityId->toRfc4122(),
                'user' => $user->id->toRfc4122(),
            ]
        );

        if (false === $activity instanceof Activity) {
            throw new NotFoundException('Activity not found');
        }

        return $activity;
    }
}
