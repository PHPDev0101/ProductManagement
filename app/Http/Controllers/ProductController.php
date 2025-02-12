<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        $product = $this->productService->index();

        if ($product->isEmpty()) {
            return response()->json([
                'status' => false, // Response::HTTP_NO_CONTENT,
                'message' => 'There are no products available at the moment.',
                'data' => $product,
            ], 200);
        }

        return response()->json([
            'status' => true, // Response::HTTP_OK,
            'message' => 'Products retrieved successfully.',
            'data' => $product,
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        if ($product === null) {
            return response()->json([
                'status' => false,
                'message' => 'The requested product does not exist.',
                'data' => $product,
            ], 404);
        }

        return response()->json([
            'status' => true, // Response::HTTP_OK,
            'message' => 'Product found successfully.',
            'data' => $product,
        ], 200);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->store($request->validated());

        return response()->json([
            'status' => true, //Response::HTTP_CREATED,
            'message' => 'Product stored successfully.',
            'data' => $product,
        ], 201);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());

        return response()->json([
            'status' => true, // Response::HTTP_OK,
            'message' => 'Product updated successfully.',
            'data' => $product,
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        if ($this->productService->destroy($id)) {
            return response()->json([
                'status' => true, //Response::HTTP_NO_CONTENT,
                'message' => 'Product deleted successfully.',
            ], 200);
        }

        return response()->json([
            'status' => false, //Response::HTTP_NO_CONTENT,
            'message' => 'The product has already been deleted or does not exist.',
        ], 404);
    }
}
