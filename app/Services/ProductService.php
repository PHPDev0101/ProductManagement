<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService
{
    private int $productsPerPage = 10;

    public function __construct(protected Product $product)
    {
    }

    public function index(): LengthAwarePaginator
    {
        try {
            return $this->product->paginate($this->productsPerPage);
        } catch (Exception $exception) {
            Log::error($exception);

            throw new Exception('Products could not be found.');
        }
    }

    public function show(int $id): Product
    {
        try {
            return $this->product->findOrFail($id);
        } catch (Exception $exception) {
            Log::error($exception);

            throw new Exception('Product could not be found.');
        }
    }

    public function store(array $data): Product
    {
        try {
            return $this->product->create($data);
        } catch (Exception $exception) {
            Log::error($exception);

            throw new Exception('Product could not be stored.');
        }
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data): Product
    {
        try {
            $product = $this->product->findOrFail($id);
            $product->update($data);

            return $product;
        } catch (Exception $exception) {
            Log::error($exception);

            throw new Exception('Product could not be updated.');
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): void
    {
        try {
            $this->product->findOrFail($id)->delete();
        } catch (Exception $exception) {
            Log::error($exception);

            throw new Exception('Product could not be deleted.');
        }
    }
}
