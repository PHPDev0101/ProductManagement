<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return LengthAwarePaginator
     *
     * @throws DatabaseException
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        try {
            return $this->productRepository->getAll();
        } catch (DatabaseException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return Product
     *
     * @throws DatabaseException
     */
    public function getProductById(int $id): Product
    {
        try {
            $product = $this->productRepository->findById($id);

            if (!$product) {
                Log::info('Product with ID: ' . $id . ' not found.');
                throw new ModelNotFoundException('Product not found');
            }

            return $product;
        } catch (DatabaseException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @param array $data
     *
     * @return Product
     *
     * @throws DatabaseException
     */
    public function createProduct(array $data): Product
    {
        try {
            return $this->productRepository->create($data);
        } catch (DatabaseException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return Product
     *
     * @throws DatabaseException
     */
    public function updateProduct(int $id, array $data): Product
    {
        try {
            return $this->productRepository->update($id, $data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        } catch (DatabaseException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return boolean
     *
     * @throws DatabaseException
     */
    public function deleteProduct(int $id): bool
    {
        try {
            return $this->productRepository->delete($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        } catch (DatabaseException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}
