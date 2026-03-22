import type { PaymentProvider } from "./payment-provider"
import type { Sale } from "./sale"

export interface SalePayment{
    payment_ref: string,
    sale_id: string,
    payment_provider_id: string,
    amount: number,
    status: string,
    external_transaction_id: string,
    reference_no: string,
    paid_at: Date,
    meta: JSON,
    created_at: Date

    sale?: Sale,
    payment_providers?: PaymentProvider,
}
