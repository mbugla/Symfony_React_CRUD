<?php

namespace Test\Support;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;

class UsersInMemoryRepository implements UserRepositoryInterface
{
    private $users = [];

    public function store(User $user): void
    {
        if (!$user->getId()) {
            $user->setId(random_int(0, 1000));
        }

        $this->users[$user->getId()] = $user;
    }

    public function delete(User $user): void
    {
        unset($this->users[$user->getId()]);
    }

    public function find($id): ?User
    {
        foreach ($this->users as $userId => $user) {
            if ($userId === $id) {
                return $user;
            }
        }

        return null;
    }

    public function getAll($limit, $offset, $orderBy = null): array
    {
        return $this->users;
    }
}
