<?php

namespace App\Services\Sale;

use App\Models\PaymentProvider;
use App\Models\Product;
use App\Models\PrPrice;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    /**
     * Create new category.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            $products = $this->getSaleItems($data['products']);
            $payment_provider = $this->getPaymentMethod($data['payment_method']);

            $subtotal = array_sum(array_column($products, 'line_total'));
            $tax_amount = $subtotal * 0.12; // Assuming a fixed tax rate
            $total_amount = $subtotal + $tax_amount;

            $sale = Sale::create([
                'sale_ref' => $data['so_number'],
                'trans_type' => 'sale',
                'subtotal' => $subtotal,
                'discount_amount' => 0,
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

            Log::info('Sale products retrieved', ['sale' => $sale, 'sale_items' => $sale_item]);
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

    private function getPaymentMethod($provider){
        return PaymentProvider::where('provider_code', $provider)->first();
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
