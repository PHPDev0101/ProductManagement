<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Interfaces\ProductServiceInterface;
use App\Services\ProductServiceConstants;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getPaginatedProducts();
        $hasProducts = $products->isNotEmpty();

        $message = $hasProducts
            ? ProductServiceConstants::MSG_PRODUCTS_RETRIEVED
            : ProductServiceConstants::MSG_NO_PRODUCTS_AVAILABLE;

        return response()->json([
            'status' => $hasProducts,
            'message' => $message,
            'data' => $products,
        ], Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->show($id);
        $productExists = $product !== null;

        $message = $productExists
            ? ProductServiceConstants::MSG_PRODUCT_FOUND
            : ProductServiceConstants::MSG_PRODUCT_NOT_EXIST;

        $statusCode = $productExists
            ? Response::HTTP_OK
            : Response::HTTP_NOT_FOUND;

        return response()->json([
            'status' => $productExists,
            'message' => $message,
            'data' => $product,
        ], $statusCode);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $product = $this->productService->store($validatedData);

        return response()->json([
            'status' => true,
            'message' => ProductServiceConstants::MSG_PRODUCT_STORED,
            'data' => $product,
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $product = $this->productService->update($id, $validatedData);

        return response()->json([
            'status' => true,
            'message' => ProductServiceConstants::MSG_PRODUCT_UPDATED,
            'data' => $product,
        ], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $isDeleted = $this->productService->destroy($id);

        $message = $isDeleted
            ? ProductServiceConstants::MSG_PRODUCT_DELETED
            : ProductServiceConstants::MSG_PRODUCT_ALREADY_DELETED;

        $statusCode = $isDeleted
            ? Response::HTTP_OK
            : Response::HTTP_NOT_FOUND;

        return response()->json([
            'status' => $isDeleted,
            'message' => $message
        ], $statusCode);
    }
}
