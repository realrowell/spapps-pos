<?php

namespace App\Services\Sale;

use App\Models\PaymentProvider;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SalePaymentService extends \App\Services\BaseService
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return SalePayment::all();
    }
    /**
     * Get all categories.
     */
    public function getAllActive(): Collection
    {
        return SalePayment::where('is_active', true)->get();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return SalePayment::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int|string $id): ?SalePayment
    {
        return SalePayment::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data ): SalePayment
    {
        return $this->transaction(function () use ($data) {

            $sale = Sale::where('sale_ref', $data['sale_id'])->firstOrFail();
            $payment_method = PaymentProvider::where('provider_code', $data['payment_method'])->first();

            $sale_payment = SalePayment::create([
                'sale_id' => $sale['id'],
                'payment_provider_id' => $payment_method->id,
                'amount' => $data['payment'],
                'external_transaction_id' => $data['external_transaction_id'] ?? null,
                'reference_no' => $data['reference_no'] ?? null,
                'paid_at' => now(),
                'status' => 'success',
            ]);

            $is_sale_payment_full = $this->checkSaleOrderPayment($sale);
            if($is_sale_payment_full){
                $sale->update([
                    'payment_status' => 'paid',
                    'status' => 'completed'
                ]);
            }
            else{
                $sale->update([
                    'payment_status' => 'partial',
                    'status' => 'partial'
                ]);
            }

            return $sale_payment;
        });
    }

    private function checkSaleOrderPayment($sale){
        $salePayments = SalePayment::where('sale_id', $sale->id)->get();
        $total_payment = $salePayments->sum('amount');
        Log::info('checkSaleOrderPayment',['payments' => $salePayments->toArray(),'total_payment' => $total_payment]);
        if($sale->total_amount == $total_payment){
            return true;
        }
        else{
            return false;
        }
    }


    /**
     * Update existing category.
     */
    public function update(SalePayment $category, array $data): SalePayment
    {
        return $this->transaction(function () use ($category, $data) {

            $category->update($data);

            return $category->refresh();
        });
    }

    // /**
    //  * Delete category.
    //  */
    public function delete(SalePayment $category): bool
    {
        return $this->transaction(function () use ($category) {

            return $category->delete();
        });
    }
}
