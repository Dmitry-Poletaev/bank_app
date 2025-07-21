<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\UpdateUserDto;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'age'   => 'sometimes|integer|min:18',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): UpdateUserDto
    {
        $data = $this->validated();
        return new UpdateUserDto(
            $data['name']  ?? null,
            $data['email'] ?? null,
            $data['age']   ?? null,
        );
    }


}
