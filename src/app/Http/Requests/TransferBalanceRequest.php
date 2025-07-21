<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\TransferBalanceDto;

class TransferBalanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_account_id' => 'required|integer',
            'to_account_id'   => 'required|integer',
            'amount'          => 'required|numeric|min:0.01',
        ];
    }

    public function authorize(): bool { return true; }

    public function toDto(): TransferBalanceDto
    {
        $data = $this->validated();
        return new TransferBalanceDto(
            (int) $data['from_account_id'],
            (int) $data['to_account_id'],
            (string) $data['amount'],
        );
    }
}
