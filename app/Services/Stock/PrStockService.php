<?php

namespace App\Services\Stock;

use App\Models\Location;
use App\Models\PrInventory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class PrStockService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return PrInventory::all();
    }
    /**
     * Get all categories.
     */
    // public function getAllActive(): Collection
    // {
    //     return PrInventory::where('is_active', true)->get();
    // }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PrInventory::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?PrInventory
    {
        return PrInventory::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {

            $product = Product::where('pr_code', $data['product'])->first();
            if (!$product) {
                throw new \Exception('Product not found');
            }

            $location = Location::where('loc_code', $data['location'])->first();
            if (!$location) {
                throw new \Exception('Location not found');
            }

            // Check if there is already an existing PrInventory for the product and location
            $existingPrInventory = PrInventory::where('pr_id', $product->id)
                                            ->where('loc_id', $location->id)
                                            ->first();

            // Update the product's average cost with the new unit cost and quantity from the input data
            $product->update([
                'avg_cost' => $this->computeWAC($data, $product),
            ]);

            if ($existingPrInventory) {
                // If an existing PrInventory is found, update its stock quantity instead of creating a new one
                $update_existing_pr_inventory = $existingPrInventory->update([
                    'stock_qty' => $existingPrInventory->stock_qty + $data['quantity']
                ]);
                return $update_existing_pr_inventory;
            }

            // If no existing PrInventory is found, create a new one with the given data
            // Create a new PrInventory if no existing one is found
            return PrInventory::create([
                'pr_id' => $product->id,
                'loc_id' => $location->id,
                'stock_qty' => $data['quantity'],
            ]);
        });
    }

    private function computeWAC($data, $product): float #return Product WAC from unit cost and quantity
    {
        if($product->avg_cost == 0 || $product->avg_cost == null){
            return $data['unit_cost'];
        }

        $oldWAC = $product->avg_cost;
        $oldQty = PrInventory::where('pr_id', $product->id)
                                    ->sum('stock_qty');

        $newWAC = (($oldWAC * $oldQty) + ($data['unit_cost'] * $data['quantity'])) / ($oldQty + $data['quantity']);
        return $newWAC;
    }

    /**
     * Update existing category.
     */
    // public function update(PrInventory $category, array $data): PrInventory
    // {
    //     return $this->transaction(function () use ($category, $data) {

    //         $category->update($data);

    //         return $category->refresh();
    //     });
    // }

    // /**
    //  * Delete category.
    //  */
    // public function delete(PrInventory $category): bool
    // {
    //     return $this->transaction(function () use ($category) {

    //         return $category->delete();
    //     });
    // }
}
