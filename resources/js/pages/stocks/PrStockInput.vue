<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import AppLayout from '@/layouts/AppLayout.vue';
import { stocksPrStockPage, stocksPrStockStore } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { type Product } from '@/types/inventories/product';
import { type Location } from '@/types/inventories/location';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product Stocks',
        href: stocksPrStockPage().url,
    },
    {
        title: 'Product Stocks Input',
        // href: saleMopsCreate().url,
    },
];

const { products } = defineProps<{
    products: Product[];
    locations: Location[];
}>()

const form = useForm({
    product: '',
    location: '',
    quantity: 0 as number,
    unit_cost: 0.00 as number,
    remarks: ''
})

const submit = () => {
    form.post(stocksPrStockStore().url)
}

console.log(products)
</script>

<template>
    <Head title="Input Product Stocks" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Input Product Stocks</h2>
                <!-- <Link :href="inventoryBrandsCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link> -->
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border pt-5 ps-5 pe-5 bg-card"
            >
                <form @submit.prevent="submit" class="flex flex-col justify-start align-center gap-5 md:items-start sm:items-stretch items-stretch">
                    <!-- <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Code">Code</Label>
                        <Input id="Code" v-model="form.code" placeholder="Enter Custom Code here.."></Input>
                        <div v-if="form.errors.code" class="text-red-500 text-sm">
                            {{ form.errors.code }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Name">Mode of Payment Name</Label>
                        <Input id="Name" v-model="form.name" placeholder="Enter category name here.."></Input>
                        <div v-if="form.errors.name" class="text-red-500 text-sm">
                            {{ form.errors.name }}
                        </div>
                    </div> -->
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Type">Product</Label>
                        <Select v-model="form.product">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select brand" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Products</SelectLabel>
                                    <SelectItem v-for="product in products" :key="product.pr_code" :value="product.pr_code">
                                        {{ product.pr_name  }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <div v-if="form.errors.product" class="text-red-500 text-sm">
                            {{ form.errors.product }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Type">Location</Label>
                        <Select v-model="form.location">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select brand" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Locations</SelectLabel>
                                    <SelectItem v-for="location in locations" :key="location.loc_code" :value="location.loc_code">
                                        {{ location.loc_name  }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <div v-if="form.errors.location" class="text-red-500 text-sm">
                            {{ form.errors.location }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Icon">Quantity</Label>
                        <Input id="Icon" v-model="form.quantity" placeholder="Enter Icon here.."></Input>
                        <div v-if="form.errors.quantity" class="text-red-500 text-sm">
                            {{ form.errors.quantity }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Icon">Unit Cost</Label>
                        <Input id="Icon" v-model="form.unit_cost" placeholder="Enter Icon here.."></Input>
                        <div v-if="form.errors.unit_cost" class="text-red-500 text-sm">
                            {{ form.errors.unit_cost }}
                        </div>
                    </div>
                    <Button type="submit" :disabled="form.processing" class="w-fit">
                        <Spinner v-if="form.processing" />
                        Submit
                    </Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
