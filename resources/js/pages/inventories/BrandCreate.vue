<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { inventoryBrands, inventoryBrandsStore } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Brands',
        href: inventoryBrands().url,
    },
    {
        title: 'Create',
    },
];


const form = useForm({
    name: '',
    description: ''
})

const onSubmit = () => {
    form.post(inventoryBrandsStore().url)
}


</script>

<template>
    <Head title="Brands" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Create Brand</h2>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border pt-5 ps-5 pe-5"
            >
                <form @submit.prevent="onSubmit" class="flex flex-col gap-5 md:items-start sm:items-stretch items-stretch">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-3">
                            <Label>Brand Name</Label>
                            <Input v-model="form.name" />
                            <div v-if="form.errors.name" class="text-red-500 text-sm">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <Label>Description</Label>
                            <Textarea v-model="form.description" />
                            <div v-if="form.errors.name" class="text-red-500 text-sm">
                                {{ form.errors.description }}
                            </div>
                        </div>
                    </div>
                    <Button type="submit" :disabled="form.processing" class="relative">
                        Submit
                    </Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
