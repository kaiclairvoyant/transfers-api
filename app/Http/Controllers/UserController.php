<?php

namespace App\Http\Controllers;

use App\Http\Request\StoreUserRequest;
use App\Http\Request\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $service;

    public function __construct()
    {
        $this->service = app(UserService::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->index(),
            Response::HTTP_OK
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->store($request->validated()),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return response()->json(
            $this->service->update($user, $request->validated()),
            Response::HTTP_NO_CONTENT
        );
    }

    public function destroy(User $user): JsonResponse
    {
        return response()->json(
            $this->service->destroy($user),
            Response::HTTP_NO_CONTENT
        );
    }
}
