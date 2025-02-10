<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use App\Exceptions\DatabaseException;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use PDOException;
use Throwable;

class ProductRepository
{
    private int $productsPerPage = 10;

    /**
     * @return LengthAwarePaginator
     *
     * @throws DatabaseException
     */
    public function getAll(): LengthAwarePaginator
    {
        try {
            return Product::paginate($this->productsPerPage);
        } catch (QueryException | PDOException $e) {
            $this->handleDatabaseException($e, 'Error retrieving all products');
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
            $this->handleDatabaseException($e, 'Error retrieving product with ID: ' . $id);
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
            $this->handleDatabaseException($e, 'Error while creating product');
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
            Log::info('Product with ID: ' . $id . ' not found'. $e->getMessage());
            throw new ModelNotFoundException('Product not found');
        } catch (QueryException | PDOException $e) {
            $this->handleDatabaseException($e, 'Error updating product');
        }
    }

    /**
     * @param int $id
     *
     * @return boolean
     *
     * @throws DatabaseException
     */
    public function delete($id): bool
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::info("Product with ID $id not found. " . $e->getMessage());
            throw new ModelNotFoundException('Product not found');
        } catch (QueryException | PDOException $e) {
            $this->handleDatabaseException($e, 'Error retrieving product with ID: ' . $id);
        }

        try {
            $product->delete();
            return true;
        } catch (QueryException | PDOException $e) {
            $this->handleDatabaseException($e, 'Error deleting product');
        }
    }

    /**
     * @param throwable $e
     * @param string $message
     *
     * @throws DatabaseException
     */
    private function handleDatabaseException(Throwable $e, string $message): void
    {
        Log::error($message . ': ' . $e->getMessage());
        throw new DatabaseException('Service currently unavailable', 500);
    }

}
