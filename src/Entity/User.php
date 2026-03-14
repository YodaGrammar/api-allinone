<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity,
    ORM\Table(name: 'aio_user'),]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    public private(set) Ulid $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    public private(set) string $email;

    /**
     * @var string[]
     */
    #[ORM\Column(type: 'json')]
    public private(set) array $roles = [];

    #[Ignore]
    #[ORM\Column(type: 'string')]
    public private(set) string $password;

    #[ORM\Column(type: 'string', nullable: true)]
    public private(set) ?string $username;

    #[ORM\Column(type: 'string', nullable: true)]
    public private(set) ?string $firstName;

    #[ORM\Column(type: 'string', nullable: true)]
    public private(set) ?string $lastName;

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    #[Ignore]
    /**
     * @return non-empty-string
     */
    public function getUserIdentifier(): string
    {
        if ('' === $this->email) {
            throw new \LogicException('The username cannot be empty.');
        }

        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }
}
