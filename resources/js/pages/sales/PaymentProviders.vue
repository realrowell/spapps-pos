<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { salePaymentProviders, salePaymentProvidersCreate, saleSales } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { type PaymentProvider } from '@/types/sale/payment-provider';
import PaymentProviderTable from './partials/PaymentProviderTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: saleSales().url,
    },
    {
        title: 'Payment Providers',
        href: salePaymentProviders().url,
    },
];

const { payment_providers } = defineProps<{
    payment_providers: PaymentProvider[]
}>()
</script>

<template>
    <Head title="Payment Providers" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Payment Providers</h2>
                <Link :href="salePaymentProvidersCreate().url">
                    <Button variant="default" >Add Provider</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card"
            >
                <PaymentProviderTable :data="payment_providers"/>
            </div>
        </div>
    </AppLayout>
</template>
