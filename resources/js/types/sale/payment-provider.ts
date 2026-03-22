import type { ModeOfPayment } from '@/types/sale/mode-of-payment'

export interface PaymentProvider {
    provider_code: string,
    provider_name: string,
    account_name: string,
    account_number: string,
    mop: ModeOfPayment,
    is_active: boolean,
    is_external_id_required: boolean
}
