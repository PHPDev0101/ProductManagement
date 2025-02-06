<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getProductById(int $id): Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): Product
    {
        return $this->productRepository->update($id,$data);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}
