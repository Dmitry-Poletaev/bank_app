<?php

namespace App\Http\Repositories\Interfaces;

use App\Dto\UpdateUserDto;
use App\Http\Repositories\Filter\UserOneFilter;
use App\Models\User;

interface UserRepositoryInterface
{
    public function update(User $user, UpdateUserDto $dto): void;
    public function one(UserOneFilter $filter): ?User;
}
