<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->productService->getAllProducts());
    }

    public function show(string $id): JsonResponse
    {
            return response()->json($this->productService->getProductById($id));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json($this->productService->createProduct($request->validated()));
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        return response()->json($this->productService->updateProduct($id, $request->validated()));
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $deleted = $this->productService->deleteProduct($id);

            if ($deleted) {
                return response()->json([
                    'message' => 'Product deleted successfully'
                ]);
            }

            return response()->json([
                'error' => 'Deletion failed',
                'message' => 'The product could not be deleted.'
            ], 500);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => $e->getMessage()
            ], 404);
        } catch (DatabaseException $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
