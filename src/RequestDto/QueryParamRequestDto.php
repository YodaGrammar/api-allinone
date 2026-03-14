<?php

declare(strict_types=1);

namespace App\RequestDto;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class QueryParamRequestDto
{
    #[Assert\Type('integer'),
        Assert\Regex(
            pattern: '/^\d+$/',
            message: 'The limit can only contain numbers.',
            match: true,
        ),
        SerializedPath('[page][limit]')]
    public mixed $limit;

    #[Assert\Type('integer'),
        Assert\Regex(
            pattern: '/^\d+$/',
            message: 'The limit can only contain numbers.',
            match: true,
        ),
        SerializedPath('[page][offset]')]
    public mixed $offset;

    /**
     * @var mixed[]
     */
    #[Assert\Type('array')]
    public mixed $filter;

    /**
     * @var mixed[]
     */
    #[Assert\Type('array')]
    public mixed $sort;

    public function __construct(
        mixed $limit = 50,
        mixed $offset = 1,
        mixed $filter = [],
        mixed $sort = null,
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->filter = $filter;
        $this->sort = $sort;
    }
}
