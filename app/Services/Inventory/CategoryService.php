<?php

namespace App\Services\Inventory;

use App\Models\PrCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return PrCategory::all();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PrCategory::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?PrCategory
    {
        return PrCategory::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data): PrCategory
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();

            return PrCategory::create([
                'cat_name' => $data['name'],
                'is_active' => true,
            ]);
        });
    }

    /**
     * Update existing category.
     */
    public function update(PrCategory $category, array $data): PrCategory
    {
        return $this->transaction(function () use ($category, $data) {

            $category->update($data);

            return $category->refresh();
        });
    }

    /**
     * Delete category.
     */
    public function delete(PrCategory $category): bool
    {
        return $this->transaction(function () use ($category) {

            return $category->delete();
        });
    }
}
