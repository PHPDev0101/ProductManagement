<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getPaginatedProducts(): LengthAwarePaginator;
    public function show(int $id): ?Product;
    public function store(array $data): Product;
    public function update(int $id, array $data): Product;
    public function destroy(int $id): bool;
}
