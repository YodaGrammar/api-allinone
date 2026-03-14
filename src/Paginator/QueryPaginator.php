<?php

declare(strict_types=1);

namespace App\Paginator;

use App\RequestDto\QueryParamRequestDto;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QueryPaginator
{
    /**
     * @return array<string, mixed>
     */
    public static function paginate(QueryBuilder $query, QueryParamRequestDto $queryParam): array
    {
        $paginator = new Paginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($queryParam->limit * ($queryParam->offset - 1))
            ->setMaxResults($queryParam->limit);

        $totalPages = 1;
        if ($queryParam->limit < $paginator->count()) {
            $totalPages = ceil($paginator->count() / $queryParam->limit);
        }

        /** @var \ArrayIterator<int|string, object> $iterator */
        $iterator = $paginator->getIterator();

        return [
            'data' => $paginator,
            'limit' => $queryParam->limit,
            'items' => $iterator->count(),
            'totalItems' => $paginator->count(),
            'page' => $queryParam->offset,
            'totalPages' => $totalPages,
        ];
    }
}
