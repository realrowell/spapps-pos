import type { Sale } from "./sale"

export interface SalePayment{
    payment_ref: string,
    sale_id: string,
    payment_provider: string,
    amount: number,
    status: string,
    external_transaction_id: string,
    reference_no: string,
    paid_at: Date,
    meta: JSON,

    sale?: Sale,
}
