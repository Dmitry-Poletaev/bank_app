<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\UseCase\User\UpdateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
Use App\Exceptions\EmailBusyException;
use Throwable;


class UserController extends Controller
{
    public function __construct(
        private readonly UpdateUser $updateUser
    )
    {
    }

    public function update(int $id, UpdateUserRequest $request): JsonResponse
    {
        try {
            $this->updateUser->handle($id, $request->toDto());
            return response()->json(['message' => 'success']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (EmailBusyException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (Throwable $e) {
            Log::error('User update failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal error'], 500);
        }
    }
}
