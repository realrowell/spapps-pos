<?php

namespace App\Services\Sale;

use App\Models\ModeOfPayment;
use App\Models\PaymentProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentProviderService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return PaymentProvider::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return PaymentProvider::where('is_active', true)->with(['mops'])->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PaymentProvider::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?PaymentProvider
    {
        return PaymentProvider::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data): PaymentProvider
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            $mop = ModeOfPayment::where('mop_code', $data['mop'])->first();

            return PaymentProvider::create([
                'provider_code' => $data['code'] ?? null,
                'provider_name' => $data['name'],
                'account_name' => $data['account_name'] ?? null,
                'account_number' => $data['account_number'] ?? null,
                'mop_id' => $mop->id ?? null,
                'is_active' => true,
            ]);
        });
    }

    /**
     * Update existing category.
     */
    public function update(PaymentProvider $category, array $data): PaymentProvider
    {
        return $this->transaction(function () use ($category, $data) {

            $category->update($data);

            return $category->refresh();
        });
    }

    // /**
    //  * Delete category.
    //  */
    public function delete(PaymentProvider $category): bool
    {
        return $this->transaction(function () use ($category) {

            return $category->delete();
        });
    }
}
