<script setup lang="ts">
import { Head, useForm, } from '@inertiajs/vue3';
import {computed } from 'vue'
import Button from '@/components/ui/button/Button.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
  NumberField,
  NumberFieldContent,
  NumberFieldDecrement,
  NumberFieldIncrement,
  NumberFieldInput,
} from '@/components/ui/number-field'
import RichTextEditor from '@/components/ui/rich-text-editor/RichTextEditor.vue'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useToggleContainerMap } from '@/composables/useToggleContainer'
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryProducts, inventoryProductsStore } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: inventoryProducts().url,
    },
    {
        title: 'Create',
    },
];

const form = useForm({
    name: '',
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


const onSubmit = () => {
    form.post(inventoryProductsStore().url)
    console.log(form.data())
}

const handleThumbnailChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    form.thumbnail = input.files?.[0] || null;
}

const { brands, categories, uomOptions, statusOptions } = defineProps<{
    brands: Array<any>;
    categories: Array<any>;
    uomOptions: Record<string, any>;
    statusOptions: Record<string, any>;
    priceTypeOptions: Record<string, any>;
    locations: Array<any>;
}>()


function clearSelect(path: string) {
    const keys = path.split('.')
    let target: any = form // allow dynamic indexing

    for (let i = 0; i < keys.length - 1; i++) {
        target = target[keys[i]]
        if (!target) return
    }

    target[keys[keys.length - 1]] = null
}


const charCount = computed(() =>
    form.short_desc?.length ?? 0
)

const { map } = useToggleContainerMap({
    showStockAlert: false,
    // enableNotifications: true, // optional default states
})
// console.log(uomOptions.key)
</script>

<template>
    <Head title="Products" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Create Product</h2>
            </div>
            <form @submit.prevent="onSubmit" class="flex flex-col gap-10 ">
                <div class="relative rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-card">
                    <div class="flex flex-col gap-8">
                        <h2 class="text-xl">Product Details</h2>
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-3">
                                <Label for="name">Product Name</Label>
                                <Input id="name" v-model="form.name" />
                                <div v-if="form.errors.name" class="text-red-500 text-sm">
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <Label for="desc">Description</Label>
                                <Textarea id="desc" v-model="form.short_desc" :maxlength="255"/>
                                <div class="text-xs text-muted-foreground text-right">
                                    {{ charCount }} / 255
                                </div>
                                <div v-if="form.errors.short_desc" class="text-red-500 text-sm">
                                    {{ form.errors.short_desc }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-row gap-5">
                                <div class="flex flex-col gap-3">
                                    <Label for="brand">Brand</Label>
                                    <div class="flex flex-row gap-1 w-50">
                                        <Select v-model="form.brand">
                                            <SelectTrigger class="w-full">
                                                <SelectValue placeholder="Select brand" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Brands</SelectLabel>
                                                    <SelectItem v-for="brand in brands" :key="brand.brand_code" :value="brand.brand_code">
                                                        {{ brand.brand_name }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <Button
                                            variant="outline"
                                            @click="clearSelect('brand')"
                                            v-if="form.brand"
                                        >
                                            Clear
                                        </Button>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <Label for="category">Category</Label>
                                    <div class="flex flex-row gap-1 w-50">
                                        <Select v-model="form.category">
                                            <SelectTrigger class="w-full truncate">
                                                <SelectValue placeholder="Select category" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Brands</SelectLabel>
                                                    <SelectItem v-for="category in categories" :key="category.cat_code" :value="category.cat_code">
                                                        {{ category.cat_name }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <Button
                                            variant="outline"
                                            @click="clearSelect('category')"
                                            v-if="form.category"
                                        >
                                            Clear
                                        </Button>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <Label for="status">Status</Label>
                                    <div class="flex flex-row gap-1 w-50">
                                        <Select v-model="form.status">
                                            <SelectTrigger class="w-full">
                                                <SelectValue placeholder="Select brand" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Brands</SelectLabel>
                                                    <SelectItem v-for="(label, value) in statusOptions" :key="value" :value="value">
                                                        {{ label  }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <Button
                                            variant="outline"
                                            @click="clearSelect('status')"
                                            v-if="form.status"
                                        >
                                            Clear
                                        </Button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row sm:flex-col gap-5">
                                <div class="flex flex-col gap-3">
                                    <Label for="sku">SKU<span class="text-xs text-muted-foreground"> (if applicable)</span></Label>
                                    <Input id="sku" v-model="form.sku" />
                                    <div v-if="form.errors.sku" class="text-red-500 text-sm">
                                        {{ form.errors.sku }}
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <Label for="barcode">Barcode<span class="text-xs text-muted-foreground"> (if applicable)</span></Label>
                                    <Input id="barcode" v-model="form.barcode" />
                                    <div v-if="form.errors.barcode" class="text-red-500 text-sm">
                                        {{ form.errors.barcode }}
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <Label for="serialNumber">Serial Number<span class="text-xs text-muted-foreground"> (if applicable)</span></Label>
                                    <Input id="serialNumber" v-model="form.serial_number" />
                                    <div v-if="form.errors.serial_number" class="text-red-500 text-sm">
                                        {{ form.errors.serial_number }}
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <Label for="warrantyInfo">Warranty Info<span class="text-xs text-muted-foreground"> (if applicable)</span></Label>
                                    <Input id="warrantyInfo" v-model="form.warranty" />
                                    <div v-if="form.errors.warranty" class="text-red-500 text-sm">
                                        {{ form.errors.warranty }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row sm:flex-col gap-5">
                            <div class="flex flex-col gap-5">
                                <div class="flex flex-row gap-3 w-50">
                                    <Checkbox id="trackInventory" class="w-5 h-auto aspect-square" v-model="form.track_inventory" />
                                    <Label for="trackInventory">Track Inventory</Label>
                                </div>
                                <div v-if="form.track_inventory" class="flex flex-col gap-3">
                                    <Label for="uom">Unit of measure</Label>
                                    <div class="flex flex-row gap-1 w-50">
                                        <Select v-model="form.uom">
                                            <SelectTrigger class="w-full">
                                                <SelectValue placeholder="Select brand" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Brands</SelectLabel>
                                                    <SelectItem v-for="(label, value) in uomOptions" :key="value" :value="value">
                                                        {{ label  }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <Button
                                            variant="outline"
                                            @click="clearSelect('uom')"
                                            v-if="form.uom"
                                        >
                                            Clear
                                        </Button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-5 w-50">
                                <div class="flex flex-row gap-3">
                                    <Checkbox id="stockAlert" class="w-5 h-auto aspect-square" v-model="map.showStockAlert" />
                                    <Label for="stockAlert">Set Stock Alert</Label>
                                </div>
                                <div v-if="map.showStockAlert" class="flex flex-col gap-3">
                                    <Label for="stockTreshold">Low Stock Threshold</Label>
                                    <NumberField
                                        v-model="form.alert_threshold"
                                        id="stockTreshold"
                                        :min="0"
                                    >
                                        <NumberFieldContent>
                                            <NumberFieldDecrement />
                                            <NumberFieldInput />
                                            <NumberFieldIncrement />
                                        </NumberFieldContent>
                                    </NumberField>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row sm:flex-col gap-5">
                            <div class="flex flex-col gap-3">
                                <Label for="thumbnail">Product Thumbnail</Label>
                                <Input id="thumbnail" type="file" @change="handleThumbnailChange"/>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <Label for="desc">Product Details</Label>
                            <RichTextEditor  id="desc" v-model="form.description"/>
                            <div v-if="form.errors.name" class="text-red-500 text-sm">
                                {{ form.errors.description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-card">
                    <div class="flex flex-col gap-8">
                        <h2 class="text-xl">Pricing<span v-if="form.track_inventory"> & Stock</span></h2>
                        <div class="flex flex-col md:flex-row sm:flex-col gap-5">
                            <div class="flex flex-col gap-3">
                                <Label for="price_type">Price Type</Label>
                                <div class="flex flex-row gap-1 w-50">
                                    <Select v-model="form.price_type">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select price type" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Price Type</SelectLabel>
                                                <SelectItem v-for="(label, value) in priceTypeOptions" :key="value" :value="value">
                                                    {{ label  }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <Button
                                        variant="outline"
                                        @click="clearSelect('price_type')"
                                        v-if="form.price_type"
                                    >
                                        Clear
                                    </Button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <Label for="price">Price</Label>
                                <NumberField
                                    v-model="form.price"
                                    id="price"
                                    :min="0"
                                    :default-value="1.00"
                                    :format-options="{
                                        style: 'currency',
                                        currency: 'PHP',
                                        currencyDisplay: 'code',
                                        currencySign: 'accounting',
                                    }"
                                >
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>
                            <div class="flex flex-col gap-3">
                                <Label for="effective_date">Effective from</Label>
                                <Input class="w-50" id="effective_date" type="date" v-model="form.price_effective_from" />
                            </div>
                            <div class="flex flex-col gap-3">
                                <Label for="effective_date">Effective to</Label>
                                <Input class="w-50" id="effective_date" type="date" v-model="form.price_effective_to" />
                            </div>
                        </div>
                        <div v-if="form.track_inventory" class="flex flex-col md:flex-row sm:flex-col gap-3">
                            <div class="flex flex-col gap-3">
                                <Label for="stock">Stock Location</Label>
                                <div class="flex flex-row gap-1 w-50">
                                    <Select v-model="form.stock_location">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select price type" />
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
                                    <Button
                                        variant="outline"
                                        @click="clearSelect('stock_location')"
                                        v-if="form.stock_location"
                                    >
                                        Clear
                                    </Button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <Label for="stock">Stock Quantity</Label>
                                <NumberField
                                    v-model="form.stock"
                                    id="stock"
                                    :default-value="1"
                                    :min="0"
                                >
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>
                        </div>
                    </div>
                </div>
                <Button type="submit" :disabled="form.processing" class="w-fit">
                    Submit
                </Button>
            </form>
        </div>
    </AppLayout>
</template>
