<?php

namespace App\Services\Sale;

use App\Models\Product;
use App\Models\PrPrice;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SaleOrderService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return Sale::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return Sale::where('is_active', true)->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Sale::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?Sale
    {
        return Sale::find($id);
    }

    public function getById(string $id){
        return Sale::where('id', $id)->with(['sale_items'])->first();
    }

    public function getByRef($ref){
        return Sale::where('sale_ref', $ref)->with(['sale_items'])->first();
    }

    /**
     * Create new category.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            $products = $this->getSaleItems($data['products']);

            $sum_of_products = array_sum(array_column($products, 'line_total'));
            $discount_amount = 500;
            $tax_amount = ($sum_of_products - $discount_amount) * 0.12; // Assuming a fixed tax rate
            $subtotal_excle_tax = $sum_of_products - $tax_amount;
            $total_amount = ($subtotal_excle_tax + $tax_amount) - $discount_amount;

            $sale = Sale::create([
                'sale_ref' => $data['so_number'],
                'trans_type' => 'sale',
                'subtotal' => $subtotal_excle_tax,
                'discount_amount' => $discount_amount,
                'tax_amount' => $tax_amount,
                'total_amount' => $total_amount,
                'status' => 'draft',
                'transacted_by' => Auth::user()->username,
                'user_id' => Auth::user()->id,
                'completed_at' => now()
            ]);

            // $sale_items
            for ($i=0; $i < count($products); $i++){
                //save to database
                // dd($locations[$i]);
                $sale_item = SaleItem::create([
                    'sale_id' => $sale->id,
                    'pr_id' => $products[$i]['pr_id'],
                    'pr_name' => $products[$i]['pr_name'],
                    'uom' => $products[$i]['uom'],
                    'qty' => $products[$i]['quantity'],
                    'price_type' => $products[$i]['price_type'],
                    'unit_price' => $products[$i]['unit_price'],
                    'line_total' => $products[$i]['line_total']
                ]);
            }
            return $sale;
        });
    }

    private function getSaleItems(array $products): array
    {
        return array_map(function ($item) {
            $product = Product::where('pr_code', $item['pr_code'])->first();
            $pr_price = PrPrice::where('pr_id', $product->id)->latest()->first();
            return [
                'pr_id' => $product->id,
                'pr_name' => $product->pr_name,
                'uom' => $product->uom,
                'price_type' => $pr_price->price_type,
                'quantity' => $item['qty'],
                'unit_price' => $pr_price->price ?? 0,
                'line_total' => $pr_price->price * $item['qty'],
            ];
        }, $products);
    }

    public function updateStatus(Sale $sale, string $status): Sale
    {
        return $this->transaction(function () use ($sale, $status) {

            $sale->update([
                'status' => $status
            ]);

            return $sale->refresh();
        });
    }

    /**
     * Update existing category.
     */
    // public function update(Sale $category, array $data): Sale
    // {
    //     return $this->transaction(function () use ($category, $data) {

    //         $category->update($data);

    //         return $category->refresh();
    //     });
    // }

    // /**
    //  * Delete category.
    //  */
    // public function delete(Sale $category): bool
    // {
    //     return $this->transaction(function () use ($category) {

    //         return $category->delete();
    //     });
    // }
}
