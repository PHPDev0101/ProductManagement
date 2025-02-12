<?php

namespace App\Interfaces;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductControllerConstants;
use Illuminate\Http\JsonResponse;

interface ProductControllerInterface
{
    public function index(): JsonResponse;
    public function show(int $id): JsonResponse;
    public function store(StoreProductRequest $request): JsonResponse;
    public function update(UpdateProductRequest $request, int $id): JsonResponse;
    public function destroy(int $id): JsonResponse;
}