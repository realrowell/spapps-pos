<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryLocations, inventoryLocationsCreate } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import LocationTable from './partials/LocationTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Locations',
        href: inventoryLocations().url,
    },
];
interface Location {
    id: string
    loc_code: string
    loc_name: string
    is_active: string
}
const { locations } = defineProps<{
    locations: Location[]
}>()
</script>

<template>
    <Head title="Locations" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Locations List</h2>
                <Link :href="inventoryLocationsCreate().url">
                    <Button variant="default" >Add Location</Button>
                </Link>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-card"
            >
                <LocationTable :data="locations"/>
            </div>
        </div>
    </AppLayout>
</template>
