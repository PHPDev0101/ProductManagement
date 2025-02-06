<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function findById($id): Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update($id, array $data): Product
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($data);
        }

        return $product;
    }

    public function delete($id): bool
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete($id);

            return true;
        }

        return false;
    }
}
