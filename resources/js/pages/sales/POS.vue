<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/vue3';
// import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { salePos } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Point of Sale',
        href: salePos().url,
    },
];
// interface Brand {
//     id: string
//     brand_code: string
//     brand_name: string
//     is_active: string
// }
// const { brands } = defineProps<{
//     brands: Brand[]
// }>()
</script>

<template>
    <Head title="Point of Sale" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Point of Sale</h2>
                <!-- <Link :href="inventoryBrandsCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link> -->
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card"
            >
                <!-- <BrandTable :data="brands"/> -->
            </div>
        </div>
    </AppLayout>
</template>
