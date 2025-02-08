<?php

namespace App\Repositories;

use App\Exceptions\DatabaseException;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PDOException;

class ProductRepository
{
    /**
     * @return Collection
     *
     * @throws DatabaseException
     */
    public function getAll(): Collection
    {
        try {
            return Product::all();
        } catch (QueryException | PDOException $e) {
            Log::error('Error retrieving all products: ' . $e->getMessage());
            throw new DatabaseException('Currently service unavailable, please try again later', 500);
        }
    }

    /**
     * @param $id
     *
     * @return Product|null
     *
     * @throws DatabaseException
     */
    public function findById($id): ?Product
    {
        try {
            return Product::find($id);
        } catch (QueryException | PDOException $e) {
            Log::error('Error retrieving product with ID: ' . $id . ': '. $e->getMessage());
            throw new DatabaseException('Service unavailable. Please try again later.');
        }
    }

    /**
     * @param array $data
     *
     * @return Product
     *
     * @throws DatabaseException
     */
    public function create(array $data): Product
    {
        try {
            return Product::create($data);
        } catch (QueryException | PDOException $e) {
            Log::error('Error while creating product: ' . $e->getMessage());
            throw new DatabaseException('Currently, the service is unavailable. Please try again later.');
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
    public function update(int $id, array $data): Product
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($data);

            return $product;
        } catch (ModelNotFoundException $e) {
            Log::info('Product with ID: ' . $id . ' not found');
            throw new ModelNotFoundException('Product not found');
        } catch (QueryException | PDOException $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            throw new DatabaseException('Currently, the service is unavailable. Please try again later.');
        }
    }

    /**
     * @throws DatabaseException
     */
    public function delete($id): bool
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::info("Product with ID $id not found.");
            throw new ModelNotFoundException('Product not found');
        } catch (QueryException | PDOException $e) {
            Log::error("Database error while finding product: " . $e->getMessage());
            throw new DatabaseException('Currently, the service is unavailable. Please try later.');
        }

        try {
            $product->delete();
            return true;
        } catch (QueryException | PDOException $e) {
            Log::error("Error deleting product: " . $e->getMessage());
            throw new DatabaseException('Currently, the service is unavailable. Please try later.');
        }
    }
}
