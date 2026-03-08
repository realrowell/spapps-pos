<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/vue3';
// import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { saleSales } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import SaleTable from './partials/SaleTable.vue';
import { Sale } from '@/types/sale/sale';
// import BrandTable from './partials/BrandTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: saleSales().url,
    },
];

const { sales } = defineProps<{
    sales: Sale[]
}>()
</script>

<template>
    <Head title="Sales" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Sales List</h2>
                <!-- <Link :href="inventoryBrandsCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link> -->
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card"
            >
                <SaleTable :data="sales"/>
            </div>
        </div>
    </AppLayout>
</template>
