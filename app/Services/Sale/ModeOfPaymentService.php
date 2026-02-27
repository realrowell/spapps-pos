<?php

namespace App\Services\Sale;

use App\Models\ModeOfPayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ModeOfPaymentService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return ModeOfPayment::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return ModeOfPayment::where('is_active', true)->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return ModeOfPayment::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?ModeOfPayment
    {
        return ModeOfPayment::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data): ModeOfPayment
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();

            return ModeOfPayment::create([
                'mop_code' => $data['code'],
                'mop_name' => $data['name'],
                'mop_type' => $data['type'],
                'lucide_icon' => $data['icon'],
                'is_active' => true,
            ]);
        });
    }

    /**
     * Update existing category.
     */
    // public function update(ModeOfPayment $category, array $data): ModeOfPayment
    // {
    //     return $this->transaction(function () use ($category, $data) {

    //         $category->update($data);

    //         return $category->refresh();
    //     });
    // }

    // /**
    //  * Delete category.
    //  */
    // public function delete(ModeOfPayment $category): bool
    // {
    //     return $this->transaction(function () use ($category) {

    //         return $category->delete();
    //     });
    // }
}
