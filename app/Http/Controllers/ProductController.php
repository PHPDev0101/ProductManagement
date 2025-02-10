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

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Products found successfully.',
            'data' => $product,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Product found successfully.',
            'data' => $product,
        ]);

    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->store($request->validated());

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'Product stored successfully.',
            'data' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Product updated successfully.',
            'data' => $product,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productService->destroy($id);

        return response()->json([
            'status' => Response::HTTP_NO_CONTENT,
            'message' => 'Product deleted successfully.',
        ]);
    }
}
