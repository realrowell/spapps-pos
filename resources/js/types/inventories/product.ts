import type { PrBrand } from "./brand";
import type { PrCategory } from "./pr-category";
import type { PrInventory } from "./pr-inventory";
import type { PrPrice } from "./pr-price";

export interface Product {
    pr_code: string
    pr_name: string
    pr_short_desc: string
    pr_desc: string
    sku: string
    barcode: string
    avg_cost: number
    alert_threshold: number
    is_track_inventory: boolean
    categories: PrCategory
    brands: PrBrand
    thumbnail: string
    uom: string
    status: string
    prices: PrPrice[]
    pr_inventories: PrInventory[]
    serial_number: string
    warranty_info: string
}

// export interface Price {
//     price_type: string
//     price: number
// }
// export interface PrInventory {
//     stock_qty: number
//     locations: {
//         loc_name: string
//     }
// }
