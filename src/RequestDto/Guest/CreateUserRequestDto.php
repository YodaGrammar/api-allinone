<?php

declare(strict_types=1);

namespace App\RequestDto\Guest;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserRequestDto {

    #[
        Assert\Type('string'),
        Assert\Email(mode: 'html5')
    ]
    public mixed $email;

    #[Assert\Type('string')]
    public mixed $password;

    public function __construct(
        string $email,
        string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }
}