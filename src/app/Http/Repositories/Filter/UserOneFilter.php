<?php

namespace App\Http\Repositories\Filter;

class UserOneFilter
{
    public function __construct(
        private readonly ?int $id   = null,
        private readonly ?string $email = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
