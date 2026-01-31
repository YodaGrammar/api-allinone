<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

trait RepositoryTrait
{
    public function persist(object $object): EntityManagerInterface
    {
        $this->getEntityManager()->persist($object);
        return $this->getEntityManager();
    }

    public function flush(): EntityManagerInterface
    {
        $this->getEntityManager()->flush();
        return $this->getEntityManager();
    }
}