<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryProducts, inventoryProductsDetails } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import type { Product } from '@/types/inventories/product';
import Label from '@/components/ui/label/Label.vue';
import { Input } from '@/components/ui/input';


const { product } = defineProps<{
    product: Product
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: inventoryProducts().url,
    },
    {
        title: 'Products Details',
        href: inventoryProductsDetails(product.pr_code).url,
    },
];

const form = useForm({
    name: product.pr_name,
    short_desc: '',
    description: '',
    sku: '',
    barcode: '',
    alert_threshold: 0,
    serial_number: '',
    warranty: '',
    category: null,
    brand: null,
    thumbnail: null as File | null,
    uom: null,
    status: 'draft',
    price_type: 'retail',
    price: 0,
    stock: null as number | null,
    price_effective_from: '',
    price_effective_to: '',
    stock_location: null,
    track_inventory: true,
})
</script>

<template>
    <Head title="Product Details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Product Details</h2>

            </div>
            <div class="relative rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-card">
                <Label>Product Name:</Label>
                <Input
                    class="disabled:text-black "
                    disabled
                    v-model="form.name"/>
                <span></span>
                <Label>Product Code: </Label>
                <span>{{ product.pr_code }}</span>
                <Label>Product Description: </Label>
                <span>{{ product.pr_desc }}</span>
            </div>
        </div>
    </AppLayout>
</template>
