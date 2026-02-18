<?php

namespace App\Services\Inventory;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return Location::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return Location::where('is_active', true)->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Location::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    // public function findById(int|string $id): ?Location
    // {
    //     return Location::find($id);
    // }

    /**
     * Create new category.
     */
    public function create(array $data): Location
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();

            return Location::create([
                'loc_name' => $data['name'],
                'loc_desc' => $data['description'],
                'is_active' => true,
            ]);
        });
    }

    /**
     * Update existing category.
     */
    // public function update(Location $category, array $data): Location
    // {
    //     return $this->transaction(function () use ($category, $data) {

    //         $category->update($data);

    //         return $category->refresh();
    //     });
    // }

    // /**
    //  * Delete category.
    //  */
    // public function delete(Location $category): bool
    // {
    //     return $this->transaction(function () use ($category) {

    //         return $category->delete();
    //     });
    // }
}
