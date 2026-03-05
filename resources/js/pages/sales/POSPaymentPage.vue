<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
// import { ScanLine, EllipsisVertical } from 'lucide-vue-next';
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
// import { Input } from '@/components/ui/input';
// import { Label } from '@/components/ui/label';
import { dashboard } from '@/routes';
import type { User } from '@/types';
import type { PaymentProvider } from '@/types/sale/payment-provider';
import type { Sale } from '@/types/sale/sale';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';


const { user, so_number, sale_order, payment_method, payment_providers } = defineProps<{
    user: User
    sale_order: Sale
    so_number: string
    payment_method: PaymentProvider
    payment_providers: PaymentProvider[]
}>()


const paymentForm = useForm({
    payment: 0,
    payment_method: '' as PaymentProvider['provider_code'] | '',
    so_number: so_number,
    sale_id: sale_order.sale_ref,
    external_transaction_id: '',
    reference_no: '',
    status: 'pending',
})

console.log(sale_order);

const formatToCurrency = (value: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    }).format(value)
}

function handlePaymentInput(value: number){
    if(value){
        paymentForm.payment = paymentForm.payment + value
    }
}

function selectPaymentProvider(provider_code: string) {
    paymentForm.payment_method = paymentForm.payment_method === provider_code ? '' : provider_code
}
</script>

<template>
    <Head title="Point of Sale - Payment" />
    <div
        class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4"
    >
        <div class="flex flex-row justify-between align-center">
            <Link :href="dashboard().url">
                <Button variant="link">&larr; Dashboard</Button>
            </Link>
            <Button variant="outline">{{ user.username }}</Button>
        </div>
        <!-- <div class="flex flex-row items-center w-full text-black">
            {{ JSON.stringify(sale_order) }}
            {{ JSON.stringify(payment_method) }}
        </div> -->
        <div class="flex flex-row w-full items-start justify-center pb-20 gap-3">
            <div class="w-3/12 ">
                <form >
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
                            </div>
                        </CardContent>
                        <CardFooter class="flex flex-col gap-3">
                            <Button
                                class="w-full"
                                type="button"
                                variant="danger"
                            >
                                Void
                            </Button>
                        </CardFooter>
                    </Card>
                </form>
            </div>
            <div class="w-5/10">
                <form action="">
                    <Card>
                        <CardHeader>
                            <Label>Payment Method</Label>
                            <div class="flex gap-1 overflow-x-auto pb-2">
                                <div
                                    v-for="provider in payment_providers"
                                    :key="provider.provider_code"
                                    @click="selectPaymentProvider(provider.provider_code)"
                                    :class="{
                                        'border-(--app-primary-color) bg-(--app-primary-color)/10 hover:bg-(--app-primary-color) shadow-lg': paymentForm.payment_method === provider.provider_code
                                    }"
                                    class="rounded-lg flex flex-col items-center justify-center border min-w-25 h-20 p-2 cursor-pointer hover:bg-muted "
                                >
                                    <span class="text-xs text-center w-full">
                                        {{ provider.provider_name }}
                                    </span>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <div class="flex flex-col gap-2">
                                <Label>Transaction ID / Reference No.</Label>
                                <Input
                                v-model="paymentForm.external_transaction_id"
                                ></Input>
                            </div>
                            <div class="flex flex-row gap-3">
                                <Card class="bg-(--app-primary-color) w-1/2">
                                    <CardContent class="text-white flex flex-row justify-between text-2xl">
                                        <span>Cash due: </span>
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
                            <div class="flex flex-col bg-neutral-200 p-2 rounded-xl">
                                <div class="flex flex-row gap-1">
                                    <Button
                                        type="button"
                                        variant="light"
                                        class="text-2xl p-10"
                                        @click="handlePaymentInput(1)"
                                    >
                                        1
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="light"
                                        class="text-2xl p-10"
                                        @click="handlePaymentInput(2)"
                                    >
                                        2
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="light"
                                        class="text-2xl p-10"
                                        @click="handlePaymentInput(3)"
                                    >
                                        3
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="light"
                                        class="text-2xl p-10"
                                        @click="handlePaymentInput(4)"
                                    >
                                        4
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </form>
            </div>
        </div>
    </div>
</template>

