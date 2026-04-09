<?php

namespace App\Listeners;

use App\Events\SaleCompleted;
use App\Models\InvLog;
use App\Models\PrInventory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleInventoryDeduction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaleCompleted $event): void
    {
        $sale = $event->sale;
        foreach ($sale->sale_items as $item) {

            $inventory = PrInventory::where('pr_id', $item->products->id)->first();

            $before = $inventory->stock_qty;
            $after = $before - $item->qty;

            // Update stock
            $inventory->update([
                'stock_qty' => $after,
            ]);

            // Log inventory
            InvLog::create([
                'pr_id' => $item->products->id,
                'pr_name' => $item->products->pr_name,
                'qty_change' => $item->qty,
                'loc_id' => $inventory->loc_id,
                'stock_br' => $before,
                'stock_af' => $after,
                'ref_type' => 'sale',
                'ref_id' => $sale->id,
                'unit_cost' => $item->products->avg_cost,
                'unit_price' => $item->unit_price,
                'remarks' => '',
            ]);
        }
    }
}
