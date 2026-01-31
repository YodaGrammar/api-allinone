<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Ulid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Ignore;


#[
    ORM\Entity,
    ORM\Table(name: 'aio_user'),
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    private Ulid $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[Ignore]
    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', nullable:true)]
    private ?string $username;

    #[ORM\Column(type: 'string', nullable:true)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', nullable:true)]
    private ?string $lastName;

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername($username): self
	{
		$this->username = $username;

		return $this;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setFirstName($firstName): self
	{
		$this->firstName = $firstName;

		return $this;
	}

    public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setLastName($lastName): self
	{
		$this->lastName = $lastName;

		return $this;
	}

    #[Ignore]
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        return;
    }
}