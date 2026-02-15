<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryCategories, inventoryCategoriesCreate } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import CategoryTable from './partials/testCategoryTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: inventoryCategories().url,
    },
];
interface Category {
  id: string
  cat_code: string
  cat_name: string
  is_active: string
}
const { categories } = defineProps<{
    categories: Category[]
}>()
</script>

<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Categories List</h2>
                <Link :href="inventoryCategoriesCreate().url">
                    <Button variant="default" >Add Category</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <CategoryTable :data="categories"/>
            </div>
        </div>
    </AppLayout>
</template>
