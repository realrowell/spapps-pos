import { type Location } from "./location";
import type { Product } from "./product";

export interface PrInventory{
    product: Product,
    stock_qty: number,
    location: Location
}
