<?php

namespace App\Http\Controllers;

use App\Http\Request\TransferRequest;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TransferController extends Controller
{
    private TransferService $service;

    public function __construct()
    {
        $this->service = app(TransferService::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->index(),
            Response::HTTP_OK
        );
    }

    public function store(TransferRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->store($request->validated()),
            Response::HTTP_CREATED
        );
    }
}
