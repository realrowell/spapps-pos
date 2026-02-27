<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { saleMops, saleMopsCreate, saleSales } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import type { ModeOfPayment } from '@/types/sale/mode-of-payment'
import MOPTable from './partials/MOPTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: saleSales().url,
    },
    {
        title: 'Mode of Payments',
        href: saleMops().url,
    },
];

const { mops } = defineProps<{
    mops: ModeOfPayment[]
}>()
</script>

<template>
    <Head title="Mode of Payments" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Mode of Payments</h2>
                <Link :href="saleMopsCreate().url">
                    <Button variant="default" >Add MOP</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card"
            >
                <MOPTable :data="mops"/>
            </div>
        </div>
    </AppLayout>
</template>
