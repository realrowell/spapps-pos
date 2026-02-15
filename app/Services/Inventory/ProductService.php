<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService extends BaseService
{
    /**
     * Get all products.
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * Get paginated products.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Product::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find product by ID.
     */
    public function findById(int|string $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Create new product.
     */
    public function create(array $data): Product
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();

            return Product::create($data);
        });
    }

    /**
     * Update existing product.
     */
    public function update(Product $product, array $data): Product
    {
        return $this->transaction(function () use ($product, $data) {

            $product->update($data);

            return $product->refresh();
        });
    }

    /**
     * Delete product.
     */
    public function delete(Product $product): bool
    {
        return $this->transaction(function () use ($product) {

            return $product->delete();
        });
    }
}
