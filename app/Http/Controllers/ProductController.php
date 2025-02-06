<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

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
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        return response()->json($this->productService->createProduct($request->all()), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
        ]);

        $product = $this->productService->updateProduct($id, $request->all());

        if (!$product) {
            return response()->json(['message'=> 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function destroy(string $id): JsonResponse
    {
        if ($this->productService->deleteProduct($id)) {
            return response()->json(['message' => 'Product deleted']);
        }

        return response()->json(['message' => 'Product not found']);
    }
}
