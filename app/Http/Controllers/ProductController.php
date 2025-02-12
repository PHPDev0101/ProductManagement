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
    public function __construct(protected ProductServiceInterface $productService)
    {
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getPaginatedProducts();
        $hasProducts = $products->isNotEmpty();

        $message = $hasProducts
            ? ProductServiceConstants::MSG_PRODUCTS_RETRIEVED
            : ProductServiceConstants::MSG_NO_PRODUCTS_AVAILABLE;

        return response()->json([
            'message' => $message,
            'data' => $products,
        ], Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        return response()->json([
            'message' => $product
                ? ProductServiceConstants::MSG_PRODUCT_FOUND
                : ProductServiceConstants::MSG_PRODUCT_NOT_EXIST,
            'data' => $product,
        ], $product ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $product = $this->productService->store($validatedData);

        return response()->json([
            'message' => ProductServiceConstants::MSG_PRODUCT_STORED,
            'data' => $product,
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $product = $this->productService->update($id, $validatedData);

        return response()->json([
            'message' => ProductServiceConstants::MSG_PRODUCT_UPDATED,
            'data' => $product,
        ], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(
            null,
            $this->productService->destroy($id)
                ? Response::HTTP_NO_CONTENT
                : Response::HTTP_NOT_FOUND
        );
    }
}
