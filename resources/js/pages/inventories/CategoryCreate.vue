<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryCategories, inventoryCategoriesStore } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: inventoryCategories().url,
    },
    {
        title: 'Create',
    },
];

// const submit = (e: Event) => {
//     const form = e.target as HTMLFormElement
//     const formData = new FormData(form)

//     router.post(inventoryCategoriesStore().url, formData)
// }

const form = useForm({
    name: ''
})

const submit = () => {
    form.post(inventoryCategoriesStore().url)
}


</script>

<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Create Category</h2>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border pt-5 ps-5 pe-5"
            >
                <form @submit.prevent="submit" class="flex flex-col justify-start align-center gap-5">
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Name">Category name</Label>
                        <Input id="Name" v-model="form.name" placeholder="Enter category name here.."></Input>
                    </div>
                    <Button type="submit">Create</Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
