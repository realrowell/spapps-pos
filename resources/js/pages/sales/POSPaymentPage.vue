<script setup lang="ts">
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { Delete } from 'lucide-vue-next';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardAction,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
    CardFooter
 } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';
import { dashboard, salePointOfSaleCreatePayment, salePointOfSaleVoidSale, salePos } from '@/routes';
import type { User } from '@/types';
import type { PaymentProvider } from '@/types/sale/payment-provider';
import type { Sale } from '@/types/sale/sale';
import { toast } from 'vue-sonner';
import Toaster from '@/components/Toaster.vue';
import { SalePayment } from '@/types/sale/sale-payment';
import { computed } from 'vue'
import formatDate from '@/composables/formatDate'
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import VoidTransactionDialog from './partials/VoidTransactionDialog.vue';


const { user, so_number, sale_order, payment_providers, sale_payments } = defineProps<{
    user: User
    sale_order: Sale
    so_number: string
    payment_providers: PaymentProvider[]
    sale_payments: SalePayment[] | null
}>()


const paymentForm = useForm({
    payment: 0 as number,
    payment_method: '' as PaymentProvider['provider_code'] | '',
    sale_id: sale_order.sale_ref,
    external_transaction_id: '',
    reference_no: '',
    status: 'pending',
    print_receipt: true,
})

const paymentSubmit = () => {
    paymentForm.post(salePointOfSaleCreatePayment().url, {
        onSuccess: () => {
            paymentForm.reset()
        }
    })
}
const voidSale = () => {
    router.post(
        salePointOfSaleVoidSale(sale_order.sale_ref),
        {},
        {
            onSuccess: () => {
                console.log('Sale voided')
            }
        }
    )
}


function selectPaymentProvider(provider_code: string) {
    paymentForm.payment_method = paymentForm.payment_method === provider_code ? '' : provider_code
}

function handlePaymentInput(value: any ){
    if(value >= '0' && value <= '9'){
        paymentForm.payment = parseInt(paymentForm.payment +  value.toString())
    }
    if(value == 100 || value == 500 || value == 1000){
        paymentForm.payment = parseInt(paymentForm.payment + value)
    }
    if(value === 'Backspace'){
        paymentForm.payment = Math.floor(paymentForm.payment/ 10)
    }
    if(value == 'clear'){
        paymentForm.payment = 0
    }
}

function handleKeyup(event: any) {
    if ((event.key >= '0' && event.key <= '9')){
        paymentForm.payment = paymentForm.payment+event.key
    }
    if(event.key === 'Backspace'){
        paymentForm.payment = Math.floor(paymentForm.payment/ 10)
    }
    if(event.key === 'Delete'){
        paymentForm.payment = 0
    }
}

// function showToast() {
//     toast.promise<{ name: string }>(
//     () =>
//       new Promise(resolve =>
//         setTimeout(() => resolve({ name: 'Event' }), 2000),
//       ),
//     {
//       loading: 'Loading...',
//       success: (data: { name: string }) => `${data.name} has been created`,
//       error: 'Error',
//     },
//   )
// }
const totalPayments = computed(() => {
  return sale_payments?.reduce((total, p) => total + Number(p.amount), 0) ?? 0
})
</script>

<template>
    <Head title="Point of Sale - Payment" />
    <!-- <Toaster /> -->
    <div
        class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4"
    >
        <div class="flex flex-row justify-between align-center">
            <Link :href="salePos().url">
                <Button variant="link">&larr; Point of Sale</Button>
            </Link>
            <Button variant="outline">{{ user.username }}</Button>
        </div>
        <div class="flex flex-row w-full items-start justify-center pb-20 gap-3">
            <div class="w-3/12 ">
                <form @submit.prevent="voidSale">
                    <Card class="  top-20 gap-1">
                        <CardHeader>
                            <CardTitle class="border-b pb-3 border-neutral-400">
                                <div class="flex flex-row justify-between">
                                    <span>Order Summary</span>
                                    <span>#{{ so_number }}</span>
                                </div>
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3 h-full overflow-y-auto ">
                            <div v-for="item in sale_order.sale_items" :key="item.id" class="flex flex-row w-full">
                                <img src="/images/default_product.jpg" alt="product image" class="fill w-1/4 aspect-square">
                                <div class="flex flex-col w-full gap-3">
                                    <div>
                                        <p class="text-sm font-bold">{{ item.pr_name }}</p>
                                        <p class="text-sm">{{ formatToCurrency(item.unit_price) }} x {{ item.qty }}</p>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <div class="text-sm">total: {{ formatToCurrency(item.line_total) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row justify-between w-full">
                                    <span>Subtotal:</span>
                                    <span>{{ formatToCurrency(sale_order.subtotal) }}</span>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <span>Discount: </span>
                                    <span>
                                        {{ formatToCurrency(sale_order.discount_amount) }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between pb-2">
                                    <span>Tax (12%): </span>
                                    <span>{{ formatToCurrency(sale_order.tax_amount) }}</span>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <span>Total Amount</span>
                                    <span>{{ formatToCurrency(sale_order.total_amount) }}</span>
                                </div>
                                <div class="flex flex-row justify-between" v-if="sale_payments && sale_payments.length > 0">
                                    <span>Total Paid</span>
                                    <span>{{ formatToCurrency(totalPayments) }}</span>
                                </div>
                                <div class="flex flex-row justify-between" v-if="sale_payments && sale_payments.length > 0">
                                    <span>Remaining payment</span>
                                    <span>
                                        {{
                                        formatToCurrency(
                                            sale_order.total_amount - (
                                                sale_payments?.reduce((total, payment) => {
                                                    return total + Number(payment.amount)
                                                }, 0) || 0
                                            )
                                        )
                                        }}
                                    </span>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter class="flex flex-col gap-3 items-stretch">
                            <VoidTransactionDialog :sale_order="sale_order"/>
                        </CardFooter>
                    </Card>
                </form>
            </div>
            <div class="w-5/10 sticky top-10 flex flex-col gap-5">
                <form @submit.prevent="paymentSubmit">
                    <Card>
                        <CardHeader>
                            <Label>Payment Method</Label>
                            <div class="flex gap-1 overflow-x-auto pb-2 pt-1">
                                <div
                                    v-for="provider in payment_providers"
                                    :key="provider.provider_code"
                                    @click="selectPaymentProvider(provider.provider_code)"
                                    :class="{
                                        'text-white border-(--app-primary-color) bg-(--app-primary-color) shadow-lg hover:-translate-y-1 transition-transform': paymentForm.payment_method === provider.provider_code
                                    }"
                                    class="rounded-lg flex flex-col items-center justify-center border border-(--app-primary-color) min-w-25 h-20 p-2 cursor-pointer hover:-translate-y-1 transition-transform"
                                >
                                    <span class="text-xs text-center w-full">
                                        {{ provider.provider_name }}
                                    </span>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <div
                                class="flex flex-col gap-2"
                                v-if="payment_providers.find(p => p.provider_code === paymentForm.payment_method)?.is_external_id_required"
                                >
                                <Label>Transaction ID / Reference No.</Label>
                                <Input
                                v-model="paymentForm.external_transaction_id"
                                ></Input>
                            </div>
                            <div class="flex flex-col gap-3" @keyup="handleKeyup" tabindex="0">
                                <div class="flex flex-row gap-3">
                                    <Card class="bg-(--app-primary-color) w-1/2">
                                        <CardContent class="text-white flex flex-row justify-between text-2xl">
                                            <span>Total due: </span>
                                            <span>{{ formatToCurrency(sale_order.total_amount) }}</span>
                                        </CardContent>
                                    </Card>
                                    <Card class="border-(--app-primary-color) w-1/2">
                                        <CardContent class=" flex flex-row justify-between text-2xl h-full">
                                            <span>Tendered: </span>
                                            <span>{{ formatToCurrency(paymentForm.payment) }}</span>
                                        </CardContent>
                                    </Card>
                                </div>
                                <div class="flex flex-row bg-neutral-200 gap-1 rounded-xl w-full p-2  ">
                                    <div class="flex flex-col w-2/3 gap-1">
                                        <div class="grid grid-cols-3 gap-1 ">
                                            <div v-for="n in 9" :key="n" class="w-full">
                                                <Button
                                                    type="button"
                                                    variant="light"
                                                    class="text-2xl p-10 w-full"
                                                    @click="handlePaymentInput(n.toString())"
                                                >
                                                    {{ n }}
                                                </Button>
                                            </div>
                                            <Button
                                                type="button"
                                                variant="light"
                                                class="text-2xl p-10 w-full"
                                                @click="handlePaymentInput('clear')"
                                            >
                                                Clear
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="light"
                                                class="text-2xl p-10 w-full"
                                                @click="handlePaymentInput(0)"
                                            >
                                                0
                                            </Button>
                                            <Button
                                                size="icon-lg"
                                                type="button"
                                                variant="light"
                                                class="text-2xl p-10 w-full"
                                                @click="handlePaymentInput('Backspace')"
                                            >
                                                <Delete class="size-8"/>
                                            </Button>
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-1/3 gap-1 ">
                                        <Button
                                            type="button"
                                            variant="light"
                                            class="text-2xl p-10 w-full"
                                            @click="handlePaymentInput(100)"
                                        >
                                            100
                                        </Button>
                                        <Button
                                            type="button"
                                            variant="light"
                                            class="text-2xl p-10 w-full"
                                            @click="handlePaymentInput(500)"
                                        >
                                            500
                                        </Button>
                                        <Button
                                            type="button"
                                            variant="light"
                                            class="text-2xl p-10 w-full"
                                            @click="handlePaymentInput(1000)"
                                        >
                                            1000
                                        </Button>
                                        <Button
                                            type="button"
                                            variant="light"
                                            class="text-2xl p-10 w-full"
                                            @click="paymentForm.payment = sale_order.total_amount"
                                        >
                                            Exact Amount
                                        </Button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row justify-between">
                                <div class="flex flex-row gap-2 align-center items-center justify-center">
                                    <Checkbox
                                        id="print-receipt"
                                        label="Print receipt"
                                        class="h-5 w-5"
                                        v-model="paymentForm.print_receipt"
                                    />
                                    <Label for="print-receipt">Print receipt</Label>
                                </div>
                                <Button
                                    size="lg"
                                    type="submit" :disabled="paymentForm.processing"
                                    class=" ">
                                    <Spinner v-if="paymentForm.processing" />
                                    Complete Transaction
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </form>

                <div class="flex flex-col gap-2 mt-5 w-full" v-if="sale_payments && sale_payments.length > 0">
                    <Label class="mb-3">Payment history</Label>
                    <div class="flex" v-for="sale_payment in sale_payments" :key="sale_payment.payment_ref">
                        <Card class="w-full">
                            <CardContent class="flex flex-row justify-between">
                                <div class="flex flex-col">
                                    <Label>{{ sale_payment.payment_providers?.provider_name }}</Label>
                                    <span>{{ formatToCurrency(sale_payment.amount) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span>{{ formatDate(sale_payment.created_at) }}</span>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                    <div class="flex flex-row justify-between mt-3">
                        <span>Total amount</span>
                        <span>{{ formatToCurrency(totalPayments) }}</span>
                    </div>
                    <div class="flex flex-row justify-between mt-3">
                        <span>Remaining amount</span>
                        <span>
                            {{
                                formatToCurrency(
                                    sale_order.total_amount - (
                                        sale_payments?.reduce((total, payment) => {
                                            return total + Number(payment.amount)
                                        }, 0) || 0
                                    )
                                )
                            }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

