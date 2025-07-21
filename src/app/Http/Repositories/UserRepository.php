<?php

namespace App\Http\Repositories;

use App\Dto\UpdateUserDto;
use App\Http\Repositories\Filter\UserOneFilter;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function update(User $user, UpdateUserDto $dto): void
    {
        $user->fill(array_filter([
            'name'  => $dto->getName(),
            'email' => $dto->getEmail(),
            'age'   => $dto->getAge(),
        ], static fn ($v) => !is_null($v)));

        $user->update();
    }

    public function one(UserOneFilter $filter): ?User
    {
        $query = User::query();

        if ($filter->getId() !== null) {
            $query->where('id', $filter->getId());
        }

        if ($filter->getEmail() !== null) {
            $query->where('email', $filter->getEmail());
        }

        return $query->first();
    }
}
