export interface Sale{
    sale_ref: string,
    trans_type: string,
    subtotal: number,
    discount_amount: number,
    tax_amount: number,
    total_amount: number,
    status: string,
    transacted_by: string,
    user_id: number,
    store_id: number,
    completed_at: Date,
    parent_sale_id: number,
    created_at: Date
}
