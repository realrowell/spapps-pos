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


const { user, so_number, sale_order, payment_method, payment_providers } = defineProps<{
    user: User
    sale_order: Sale
    so_number: string
    payment_method: PaymentProvider
    payment_providers: PaymentProvider[]
}>()

console.log(sale_order);

// const formatToCurrency = (value: number) => {
//     return new Intl.NumberFormat('en-PH', {
//         style: 'currency',
//         currency: 'PHP',
//     }).format(value)
// }
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
        <div class="flex flex-row items-center w-full text-black">
            {{ JSON.stringify(sale_order) }}
            {{ JSON.stringify(payment_method) }}
        </div>
        <div class="flex flex-row w-full items-start">
            <div class="w-3/12 self-start">
                <form >
                    <Card class="fixed right-4 top-20 w-[24%] gap-1">
                        <CardHeader>
                            <CardTitle class="border-b pb-3 border-neutral-400">
                                <div class="flex flex-row justify-between">
                                    <span>Order Summary</span>
                                    <span>#{{ so_number }}</span>
                                </div>
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3 h-full overflow-y-auto max-h-[40vh] min-h-[40vh]">


                        </CardContent>
                        <CardFooter class="flex flex-col gap-3">


                        </CardFooter>
                    </Card>
                </form>
            </div>
        </div>
    </div>
</template>

