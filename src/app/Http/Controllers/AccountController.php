<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferBalanceRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\UseCase\Account\DepositBalance;
use App\UseCase\Account\TransferBalance;
use App\Http\Requests\DepositBalanceRequest;
use Illuminate\Support\Facades\Log;
use Throwable;

class AccountController extends Controller
{
    public function __construct(
        private readonly DepositBalance  $depositBalance,
        private readonly TransferBalance $transferBalance,
    )
    {
    }

    public function depositBalance(int $id, DepositBalanceRequest $request): JsonResponse
    {
        try {
            $this->depositBalance->handle($id, $request->getAmount());
            return response()->json(['message' => 'success']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable $e) {
            Log::error('Deposit failed', ['accountId' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal error'], 500);
        }
    }

    public function transferBalance(TransferBalanceRequest $request): JsonResponse
    {
        try {
            $this->transferBalance->handle($request->toDto());
            return response()->json(['message' => 'success']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable $e) {
            dd($e->getMessage());
            Log::error('Transfer balance failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal error'], 500);
        }
    }
}
