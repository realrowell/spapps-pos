<script setup lang="ts">
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ScanLine, EllipsisVertical } from 'lucide-vue-next';
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
import { Input } from '@/components/ui/input';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import { Label } from '@/components/ui/label';
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';
import { dashboard, salePointOfSaleCreate } from '@/routes';
import type { User } from '@/types';
import type { PrBrand } from '@/types/inventories/brand';
import type { PrCategory } from '@/types/inventories/pr-category';
import type { Product } from '@/types/inventories/product';
import type { PaymentProvider } from '@/types/sale/payment-provider';
import { Toaster } from '@/components/ui/sonner'
import { useFlashToast } from '@/composables/useFlashToast'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import UnpaidTransactionDialog from './partials/UnpaidTransactionsDialog.vue'
import { ref } from 'vue'
import type { Sale } from '@/types/sale/sale';

useFlashToast()

const dialogOpen = ref(false)

const { user, categories, brands, so_number, payment_providers } = defineProps<{
    user: User
    categories: PrCategory[]
    brands: PrBrand[]
    products: Product[]
    so_number: string
    payment_providers: PaymentProvider[]
    sales: Sale[]
}>()

const searchForm = useForm({
    search: '',
    category: '',
    brand: '',
    product: '',
})

// const cartForm = useForm({
//     products: [] as Product[],
//     qty: 1,
//     net_total: 0,
// })
interface CartItem {
    pr_code: string
    pr_name: string
    price: number
    qty: number
    total: number
}

const cartForm = useForm({
    products: [] as CartItem[],
    net_total: 0,
    // payment_method: '' as PaymentProvider['provider_code'] | '',
    so_number: so_number
})

function addToCart(product: any) {

    const retailPrice = product.prices.find(
        (p: any) => p.price_type === 'retail'
    )?.price ?? 0

    const existing = cartForm.products.find(
        item => item.pr_code === product.pr_code
    )

    if (existing) {
        existing.qty++
        existing.total = existing.qty * existing.price
    } else {
        cartForm.products.push({
            pr_code: product.pr_code,
            pr_name: product.pr_name,
            price: Number(retailPrice),
            qty: 1,
            total: Number(retailPrice),
        })
    }

    updateCartTotal()
}

function updateCartTotal() {
    cartForm.net_total = cartForm.products.reduce(
        (sum, item) => sum + item.total,
        0
    )
}

function decreaseQty(pr_code: string) {
    const item = cartForm.products.find(item => item.pr_code === pr_code)

    if (!item) return

    if (item.qty <= 1) {
        removeFromCart(pr_code)
    } else {
        item.qty -= 1
        item.total = item.qty * item.price
    }

    updateCartTotal()
}

function removeFromCart(pr_code: string) {
    const index = cartForm.products.findIndex(item => item.pr_code === pr_code)
    if (index !== -1) {
        cartForm.products.splice(index, 1)
        updateCartTotal()
    }
}

const cartSubmit = () => {
    cartForm.post(salePointOfSaleCreate().url, {
        onSuccess: () => {
            cartForm.reset()
        }
    })
}

// function selectPaymentProvider(provider_code: string) {
//     cartForm.payment_method = cartForm.payment_method === provider_code ? '' : provider_code
// }

// console.log(payment_providers)
// const products = computed(() => {
//     let filteredProducts = categories.length > 0
//         ? products.filter(p => p.pr_category === searchForm.category)
//         : products

//     filteredProducts = brands.length > 0
//         ? filteredProducts.filter(p => p.pr_brand === searchForm.brand)
//         : filteredProducts

//     return filteredProducts
// })

const toggleCategory = (id: string) => {
    console.log(id)
    searchForm.category =
        searchForm.category === id ? '' : id
}
const toggleBrand = (id: string) => {
    searchForm.brand =
        searchForm.brand === id ? '' : id
}
</script>

<template>
    <Head title="Point of Sale" />
    <Toaster rich-colors position="bottom-center"/>
    <div
        class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4"
    >
        <div class="flex flex-row justify-between align-center">
            <Link :href="dashboard().url">
                <Button variant="link">&larr; Dashboard</Button>
            </Link>
            <Button variant="outline" >{{ user.username }}</Button>
        </div>
        <div class="flex flex-row w-full items-start">
            <div class="w-9/12 p-3 flex flex-col gap-3 ">
                <div class="flex flex-row w-full gap-1">
                    <Input id="Search" class="bg-white" v-model="searchForm.search" placeholder="Enter Product here.."></Input>
                    <Button>Search</Button>
                    <Button><ScanLine /></Button>
                    <DropdownMenu>
                        <DropdownMenuTrigger>
                            <Button><EllipsisVertical /></Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent>
                        <DropdownMenuItem @click="dialogOpen = true">
                            Unpaid Transactions
                        </DropdownMenuItem>
                        <DropdownMenuItem>Paid Transactions</DropdownMenuItem>
                        <DropdownMenuItem>Voided Transactions</DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                    <UnpaidTransactionDialog v-model:open="dialogOpen" :sales="sales" />
                </div>
                <!-- <div class="flex flex-col gap-3 w-full overflow-x-auto">
                    <Label>Category</Label>
                    <div class="flex flex-row gap-1">
                        <div
                            v-for="category in categories"
                            :key="category.cat_code"
                            class="col-span-3"
                        >
                            <div
                                @click="toggleCategory(category.cat_code)"
                                class="cursor-pointer border rounded-lg p-4 transition text-nowrap"
                                :class="searchForm.category === category.cat_code
                                    ? 'border-blue-500 bg-blue-50 shadow-lg'
                                    : 'border-gray-300 bg-white hover:border-blue-400'"
                            >
                                {{ category.cat_name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <Label>Brand</Label>
                    <div class="flex flex-row gap-1 w-full overflow-x-auto ps-3">
                        <div
                            v-for="brand in brands"
                            :key="brand.brand_code"
                            class="col-span-3 pb-3"
                        >
                            <div
                                @click="toggleBrand(brand.brand_code)"
                                class="cursor-pointer border shadow-xl rounded-lg p-4 transition text-nowrap"
                                :class="searchForm.brand === brand.brand_code
                                    ? 'border-blue-500 bg-blue-50 shadow-lg'
                                    : 'border-gray-300 bg-white hover:border-blue-400'"
                            >
                                {{ brand.brand_name }}
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="flex flex-col gap-3 w-full">
                    <Label>Products</Label>
                    <div class="flex flex-row w-full overflow-x-auto flex-wrap">
                        <div
                            v-for="product in products"
                            :key="product.pr_code"
                            class="w-1/5 p-1"
                        >
                            <Card class="gap-2 h-full">
                                <CardHeader >
                                    <!-- <AspectRatio :ratio="16 / 9" class="w-full">
                                        <img src="/images/default_product.jpg" alt="product image" fit class="fit">
                                    </AspectRatio> -->
                                    <CardTitle class="line-clamp-2 text-sm">{{ product.pr_name }}</CardTitle>
                                    <!-- <CardDescription class="truncate">{{ product.pr_short_desc ?? '...'  }}</CardDescription> -->
                                </CardHeader>
                                <CardContent class="flex flex-col gap-3">
                                    <div class="flex flex-col text-sm">
                                        <p
                                            v-for="price in product.prices"
                                            :key="price.price_code">
                                            Price: <span v-if="price.price_type == 'retail'">{{ formatToCurrency(price.price) }}</span>
                                        </p>
                                        <!-- <p>Price: {{ product.prices[0]?.price }}</p> -->
                                        <p>
                                            In-stock ({{
                                                product.pr_inventories?.reduce(
                                                (total, inv) => total + Number(inv.stock_qty),
                                                0
                                                )
                                            }})
                                        </p>
                                    </div>
                                </CardContent>
                                <CardFooter>
                                    <CardAction class="w-full">
                                        <Button
                                            @click="addToCart(product)"
                                            class=" w-full"
                                            size="sm"
                                            >
                                            + Add to Cart
                                        </Button>
                                    </CardAction>
                                </CardFooter>
                            </Card>
                        </div>
                    </div>


                </div>
            </div>
            <div class="w-3/12  sticky top-10">
                <form @submit.prevent="cartSubmit">
                    <Card class="  gap-1">
                        <CardHeader>
                            <CardTitle class="border-b pb-3 border-neutral-400">
                                <div class="flex flex-row justify-between">
                                    <span>Order Summary</span>
                                    <span>#{{ so_number }}</span>
                                </div>
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3 h-full overflow-y-auto max-h-[45vh] min-h-[45vh]">
                            <div v-if="cartForm.products.length === 0" class="text-center text-gray-500">
                                Cart is empty
                            </div>
                            <div v-for="item in cartForm.products" :key="item.pr_code" class="flex flex-row w-full">
                                <img src="/images/default_product.jpg" alt="product image" class="fill w-1/4 h-full aspect-square">
                                <div class="flex flex-col w-full">
                                    <div>
                                        <p class="text-sm">{{ item.pr_name }}</p>
                                        <p class="text-sm">{{ formatToCurrency(item.price) }}</p>
                                    </div>
                                    <!-- Add buttons to increase/decrease quantity -->
                                    <div class="flex flex-row justify-between max-w-full">
                                        <div class="flex flex-row gap-1 items-center">
                                            <Button type="button" size="xs" variant="subtlePrimary" class="border border-(--app-primary-color)" @click="decreaseQty(item.pr_code)">-</Button>
                                            <span class="bg-neutral-100 px-3">{{ item.qty }}</span>
                                            <Button type="button" size="xs" @click="addToCart({ pr_code: item.pr_code, pr_name: item.pr_name, prices: [{ price_type: 'retail', price: item.price }] })">+</Button>
                                        </div>
                                        <span class="text-(--app-primary-color)">{{ formatToCurrency(item.total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter class="flex flex-col gap-3">
                            <div class="border-t border-gray-400 pt-3 mt-3 w-full">
                                <div class="bg-gray-100 border border-neutral-300 rounded-xl flex flex-col w-full p-5 gap-1 text-sm">
                                    <div class="flex flex-row justify-between w-full">
                                        <span>Subtotal:</span>
                                        <span>{{ formatToCurrency(cartForm.net_total / 1.12) }}</span>
                                    </div>
                                    <div class="flex flex-row justify-between">
                                        <span>Discount: </span>
                                        <span>
                                            {{ formatToCurrency(0) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-row justify-between pb-2">
                                        <span>Tax (12%): </span>
                                        <span>{{ formatToCurrency(cartForm.net_total * 0.12) }}</span>
                                    </div>
                                    <div class="flex flex-row justify-between border-t border-neutral-400 pt-2">
                                        <span>Total: </span>
                                        <span>{{ formatToCurrency(cartForm.net_total) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 w-full">
                                <!-- <Label>Payment Method</Label>
                                <div class="flex gap-1 overflow-x-auto pb-2">
                                    <div
                                        v-for="provider in payment_providers"
                                        :key="provider.provider_code"
                                        @click="selectPaymentProvider(provider.provider_code)"
                                        :class="{
                                            'border-(--app-primary-color) bg-(--app-primary-color)/10 hover:bg-(--app-primary-color) shadow-lg': cartForm.payment_method === provider.provider_code
                                        }"
                                        class="rounded-lg flex flex-col items-center justify-center border min-w-25 h-20 p-2 cursor-pointer hover:bg-muted "
                                    >
                                        <span class="text-xs text-center w-full">
                                            {{ provider.provider_name }}
                                        </span>
                                    </div>
                                </div> -->
                            </div>
                            <Button
                                variant="subtlePrimary"
                                size="lg"
                                type="button" :disabled="cartForm.processing" class="w-full border border-(--app-primary-color)">
                                <Spinner v-if="cartForm.processing" />
                                Add Discount
                            </Button>
                            <Button
                                size="lg"
                                type="submit" :disabled="cartForm.processing" class="w-full">
                                <Spinner v-if="cartForm.processing" />
                                Proceed Payment
                            </Button>
                        </CardFooter>
                    </Card>
                </form>
            </div>
        </div>
    </div>
</template>
<style>
    @keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-100%); }
}

.animate-scroll {
  animation: scroll 4s linear infinite;
}
</style>
