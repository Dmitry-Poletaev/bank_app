<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositBalanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount'  => 'required|numeric|min:0.01',
        ];
    }

    public function authorize(): bool { return true; }

    public function getAmount(): float
    {
        return $this->input('amount');
    }
}
