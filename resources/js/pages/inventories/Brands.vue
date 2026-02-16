<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryBrands, inventoryCategoriesCreate } from '@/routes';
import { type BreadcrumbItem } from '@/types';
// import CategoryTable from './partials/CategoryTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Brands',
        href: inventoryBrands().url,
    },
];
interface Brands {
    id: string
    cat_code: string
    cat_name: string
    is_active: string
}
const { brands } = defineProps<{
    brands: Brands[]
}>()
</script>

<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Brands List</h2>
                <Link :href="inventoryCategoriesCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <!-- <CategoryTable :data="categories"/> -->
            </div>
        </div>
    </AppLayout>
</template>
