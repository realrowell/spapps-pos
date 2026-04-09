<?php

namespace App\Services\Inventory;

use App\Models\Location;
use App\Models\PrBrand;
use App\Models\PrCategory;
use App\Models\PrInventory;
use App\Models\Product;
use App\Models\PrPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService extends \App\Services\BaseService
{
    /**
     * Get all products.
     */
    public function getAll(): Collection
    {
        return Product::with(['categories', 'brands', 'prices', 'pr_inventories.location'])->get();
    }

    public function getAllActive(){
        return Product::where('status', 'active')->with(['categories', 'brands', 'prices', 'pr_inventories.location'])->get();
    }

    /**
     * Get stuses products.
     */
    public function getStatus(): array
    {
        return Product::statusOptions();
    }

    /**
     * Get unit of measures products.
     */
    public function getUom(): array
    {
        return Product::uomOptions();
    }

    /**
     * Get unit of measures products.
     */
    public function getPriceType(): array
    {
        return PrPrice::priceTypeOptions();
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
     * Find product by ID.
     */
    public function findByCode(int|string $id): ?Product
    {
        return Product::where('pr_code',$id)->with(['categories','brands','prices','inv_logs','pr_inventories.location','pr_inventories.product'])->first();
    }

    /**
     * Create new product.
     */
    public function create(array $data): Product
    {
        return $this->transaction(function () use ($data) {

            // Example business logic
            // $data['created_by'] = auth()->id();
            $cat_id = PrCategory::select('id')->where('cat_code', $data['category'])->first();
            $brand_id = PrBrand::select('id')->where('brand_code', $data['brand'])->first();
            $loc_id = Location::select('id')->where('loc_code', $data['stock_location'])->first();

            $product = Product::create([
                'pr_name' => $data['name'],
                'pr_short_desc' => $data['short_desc'] ?? null,
                'pr_desc' => $data['description'] ?? null,
                'sku' => $data['sku'] ?? null,
                'barcode' => $data['barcode'] ?? null,
                'alert_threshold' => $data['alert_threshold'] ?? null,
                'serial_number' => $data['serial_number'] ?? null,
                'warranty_info' => $data['warranty'] ?? null,
                'cat_id' => $cat_id->id,
                'brand_id' => $brand_id->id,
                'uom' => $data['uom'],
                'status' => $data['status'],
                'is_track_inventory' => $data['track_inventory'] ?? false,
            ]);

            $price = PrPrice::create([
                'pr_id' => $product->id,
                'price_type' => $data['price_type'],
                'price' => $data['price'],
                'is_active' => true,
                'effective_from' => $data['price_effective_from'],
                'effective_to' => $data['price_effective_to']
            ]);

            if($data['stock'] && $loc_id->id ?? null){
                $inventory = PrInventory::create([
                    'pr_id' => $product->id,
                    'stock_qty' => $data['stock'],
                    'loc_id' => $loc_id->id
                ]);
            }

            return $product;
        });
    }

    public function createPricing(array $data){
        $product = Product::where('pr_code', $data['product_id'])->first();
        $current_pr_price = PrPrice::where('pr_id', $product->id)->where('price_type', $data['price_type'])->get();
        if(!empty($current_pr_price)){
            return false;   //this will determine by the controller as error. | This will throw error via controller.
        }

        return $this->transaction(function () use ($data, $product){
            $new_pr_price = PrPrice::create([
                'pr_id' => $product->id,
                'price_type' => $data['price_type'],
                'price' => $data['price'],
                'effective_from' => $data['effective_from'] ?? null,
                'effective_to' => $data['effective_to'] ?? null,
                'is_active' => false
            ]);

            return $new_pr_price;
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
