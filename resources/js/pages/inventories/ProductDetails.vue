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
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';


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
                <div class="flex flex-row gap-3">
                    <div class="flex flex-col gap-2 flex-1">
                        <img src="/images/default_product.jpg" alt="product image" class="fill w-full h-auto aspect-square border-4">
                    </div>
                    <div class="flex flex-col gap-2 flex-2">
                        <h3 class="text-xl">{{ product.pr_name }}</h3>
                        <p class="text-sm text-muted-foreground">{{ product.pr_short_desc }}</p>
                        <div class="flex flex-row gap-3">
                            <div v-for="price in product.prices" :key="price.price_code" class="flex flex-col gap-1">
                                <Card class="w-48">
                                    <CardContent>
                                        <CardTitle>{{ price.price_type }}</CardTitle>
                                        <CardDescription v-if="price.effective_from != null && price.effective_to != null">
                                            Effective from {{ price.effective_from }} to {{ price.effective_to }}
                                        </CardDescription>
                                        <p class="text-lg font-semibold">{{ formatToCurrency(price.price) }}</p>
                                    </CardContent>
                                </Card>
                            </div>
                        </div>
                        <div class="flex flex-row gap-3">
                            <Button variant="outline" size="sm">Edit</Button>
                            <Button variant="outline" size="sm" color="destructive">Delete</Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
