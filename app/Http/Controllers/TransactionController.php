<?php

namespace App\Http\Controllers;

use App\Http\Request\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct()
    {
        $this->service = app(TransactionService::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->index(),
            Response::HTTP_OK
        );
    }

    public function store(TransactionRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->store($request->validated()),
            Response::HTTP_CREATED
        );
    }
}
