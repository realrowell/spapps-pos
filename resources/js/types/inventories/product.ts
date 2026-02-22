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
    categories: {
        cat_name: string
    }
    brands: {
        brand_name: string
    }
    thumbnail: string
    uom: string
    status: string
    prices: Price[]
    pr_inventories: PrInventory[]
    serial_number: string
    warranty_info: string
}

export interface Price {
    price_type: string
    price: number
}
export interface PrInventory {
    stock_qty: number
    locations: {
        loc_name: string
    }
}
