<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
// import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryProducts } from '@/routes';
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
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
            </div>
        </div>
    </AppLayout>
</template>
