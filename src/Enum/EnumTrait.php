<?php

declare(strict_types=1);

namespace App\Enum;

trait EnumTrait
{
    /** @var string[] */
    private const array HIDDEN_VALUES = [];

    /**
     * @return mixed[]
     */
    public static function values(bool $hideValues = true): array
    {
        $values = array_column(self::cases(), 'value');

        if (true === $hideValues) {
            $values = array_diff($values, self::HIDDEN_VALUES);
        }

        return $values;
    }
}
