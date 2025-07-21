<?php

declare(strict_types=1);

namespace App\UseCase\User;
use App\Dto\UpdateUserDto;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Filter\UserOneFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\EmailBusyException;

class UpdateUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    public function handle(int $id, UpdateUserDto $dto): void
    {
        $user = $this->userRepository->one(new UserOneFilter(id: $id));

        if ($user == null) {
            throw new ModelNotFoundException("User #$id not found");
        }

        if ($dto->getEmail() !== null) {
            $exists = $this->userRepository->one(new UserOneFilter(email: $dto->getEmail()));
            if ($exists && $exists->id !== $user->id) {
                throw new EmailBusyException("Email {$dto->getEmail()} already taken");
            }
        }

        $this->userRepository->update($user, $dto);
    }
}
