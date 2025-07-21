<?php

namespace App\Dto;

class UpdateUserDto
{
    public function __construct(
        private readonly ?string $name,
        private readonly ?string $email,
        private readonly ?int    $age,
    ) {}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }
}
