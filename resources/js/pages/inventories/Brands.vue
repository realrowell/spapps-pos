<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryBrands, inventoryBrandsCreate } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import BrandTable from './partials/BrandTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Brands',
        href: inventoryBrands().url,
    },
];
interface Brand {
    id: string
    brand_code: string
    brand_name: string
    is_active: string
}
const { brands } = defineProps<{
    brands: Brand[]
}>()
</script>

<template>
    <Head title="Brands" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Brands List</h2>
                <Link :href="inventoryBrandsCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <BrandTable :data="brands"/>
            </div>
        </div>
    </AppLayout>
</template>
