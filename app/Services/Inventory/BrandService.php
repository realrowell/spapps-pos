<?php

namespace App\Services\Inventory;

use App\Models\PrBrand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return PrBrand::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return PrBrand::where('is_active', true)->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PrBrand::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    // public function findById(int|string $id): ?PrBrand
    // {
    //     return PrBrand::find($id);
    // }

    /**
     * Create new category.
     */
    public function create(array $data): PrBrand
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();

            return PrBrand::create([
                'brand_name' => $data['name'],
                'brand_desc' => $data['description'],
                'is_active' => true,
            ]);
        });
    }

    /**
     * Update existing category.
     */
    // public function update(PrBrand $category, array $data): PrBrand
    // {
    //     return $this->transaction(function () use ($category, $data) {

    //         $category->update($data);

    //         return $category->refresh();
    //     });
    // }

    // /**
    //  * Delete category.
    //  */
    // public function delete(PrBrand $category): bool
    // {
    //     return $this->transaction(function () use ($category) {

    //         return $category->delete();
    //     });
    // }
}
