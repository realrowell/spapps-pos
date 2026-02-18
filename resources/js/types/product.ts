export interface Product {
    pr_code: string
    pr_name: string
    pr_desc: string
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
