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
import {
  RadioGroup,
  RadioGroupItem,
} from '@/components/ui/radio-group';
import { Plus } from 'lucide-vue-next';
import AddPricingDialog from './partials/AddPricingDialog.vue';
import { ref } from 'vue';

const pricingDialogOpen = ref(false);

const { product, product_statuses, price_types, uom_options } = defineProps<{
    product: Product
    product_statuses: any
    price_types: any
    uom_options: any
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
            <div class="grid grid-cols-4 gap-3">
                <div class="col-span-1 flex flex-col gap-5 justify-start p-5 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card">
                    <div class="flex flex-col gap-2">
                        <img src="/images/default_product.jpg" alt="product image" class="fill w-full h-auto aspect-square border-4">
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="text-muted-foreground">Status</span>
                        <RadioGroup :default-value="product.status">
                            <div class="flex flex-col items-start gap-3">
                                <div
                                    v-for="(label, key) in product_statuses"
                                    :key="key"
                                    class="flex items-center space-x-2"
                                >
                                    <RadioGroupItem :id="String(key)" :value="String(key)" />
                                    <Label :for="String(key)">{{ label }}</Label>
                                </div>
                            </div>
                        </RadioGroup>
                    </div>
                </div>
                <div class="col-span-3 flex flex-col gap-5 p-5 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card">
                    <h2 class="text-xl">General Information</h2>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl">{{ product.pr_name }}</h3>
                        <p class="text-sm text-muted-foreground">{{ product.pr_short_desc }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="grid grid-cols-4 gap-3">
                            <div class="flex flex-col" v-if="product.sku">
                                <span class="text-muted-foreground">SKU:</span>
                                <span>{{ product.sku }}</span>
                            </div>
                            <div class="flex flex-col" v-if="product.barcode">
                                <span class="text-muted-foreground">Barcode:</span>
                                <span>{{ product.barcode }}</span>
                            </div>
                            <div class="flex flex-col" v-if="product.serial_number">
                                <span class="text-muted-foreground">Serial Number:</span>
                                <span>{{ product.serial_number }}</span>
                            </div>
                            <div class="flex flex-col" v-if="product.warranty_info">
                                <span class="text-muted-foreground">Warranty info:</span>
                                <span>{{ product.warranty_info }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <div class="flex flex-col">
                                <span class="text-muted-foreground">Brand:</span>
                                <span>{{ product.brands.brand_name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted-foreground">Category:</span>
                                <span>{{ product.categories.cat_name }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <div class="flex flex-col">
                                <span class="text-muted-foreground">Sold per:</span>
                                <span>
                                    {{ uom_options?.[product.uom as keyof typeof uom_options] || product.uom }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted-foreground">Cost (WAC):</span>
                                <span>{{ formatToCurrency(product.avg_cost) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-muted-foreground">Pricing:</span>
                        <div class="flex flex-row gap-3">
                            <div v-for="price in product.prices" :key="price.price_code">
                                <div class="flex flex-col gap-1 w-48 rounded-lg border border-(--app-primary-color) p-5 bg-card">
                                    <span>{{ price.price_type }}</span>
                                    <div v-if="price.effective_from != null && price.effective_to != null">
                                        Effective from {{ price.effective_from }} to {{ price.effective_to }}
                                    </div>
                                    <p class="text-lg ">{{ formatToCurrency(price.price) }}</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col gap-1 w-48 rounded-lg border border-(--app-primary-color) p-5 bg-card cursor-pointer hover:bg-(--app-primary-color) hover:text-white transition-colors duration-200"
                                @click="pricingDialogOpen = true"
                            >
                                <div class="justify-center items-center text-center">
                                    <Plus class="mx-auto" />
                                    Add pricing
                                </div>
                            </div>
                            <AddPricingDialog v-model:open="pricingDialogOpen" :product="product" :price_types="price_types"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-muted-foreground">Stock:</span>
                        <div class="flex flex-row gap-3">
                            <div v-for="inventory in product.pr_inventories" :key="inventory.location.loc_code" class="flex flex-col gap-1">
                                <Card class="w-48 border-(--app-primary-color)">
                                    <CardContent>
                                        {{ inventory.location.loc_name }}
                                        <p class="text-lg ">{{ inventory.stock_qty }}</p>
                                    </CardContent>
                                </Card>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-muted-foreground">Product Details:</h3>
                        <div v-html="product.pr_desc"/>
                    </div>
                    <div class="flex flex-row gap-3">
                        <Button variant="outline" size="sm">Edit</Button>
                        <Button variant="outline" size="sm" color="destructive">Delete</Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
