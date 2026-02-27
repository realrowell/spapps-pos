<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import AppLayout from '@/layouts/AppLayout.vue';
import { saleModeOfPaymentsStore, saleMops, saleMopsCreate, saleSales } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: saleSales().url,
    },
    {
        title: 'Mode of Payments',
        href: saleMops().url,
    },
    {
        title: 'Create Mode of Payment',
        href: saleMopsCreate().url,
    },
];

const { typeOptions, generatedCode } = defineProps<{
    typeOptions: any;
    generatedCode: string;
}>()

const form = useForm({
    name: '',
    code: generatedCode,
    type: '',
    icon: '',
})

const submit = () => {
    form.post(saleModeOfPaymentsStore().url)
}

console.log(generatedCode)
</script>

<template>
    <Head title="Create Mode of Payments" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Create Mode of Payments</h2>
                <!-- <Link :href="inventoryBrandsCreate().url">
                    <Button variant="default" >Add Brand</Button>
                </Link> -->
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border pt-5 ps-5 pe-5 bg-card"
            >
                <form @submit.prevent="submit" class="flex flex-col justify-start align-center gap-5 md:items-start sm:items-stretch items-stretch">
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Code">Code</Label>
                        <Input id="Code" v-model="form.code" placeholder="Enter Custom Code here.."></Input>
                        <div v-if="form.errors.code" class="text-red-500 text-sm">
                            {{ form.errors.code }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Name">Mode of Payment Name</Label>
                        <Input id="Name" v-model="form.name" placeholder="Enter category name here.."></Input>
                        <div v-if="form.errors.name" class="text-red-500 text-sm">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Type">Type</Label>
                        <Select v-model="form.type">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select brand" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Brands</SelectLabel>
                                    <SelectItem v-for="(label, value) in typeOptions" :key="value" :value="value">
                                        {{ label  }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <div v-if="form.errors.type" class="text-red-500 text-sm">
                            {{ form.errors.type }}
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Icon">Icon (Lucide Icons)</Label>
                        <Input id="Icon" v-model="form.icon" placeholder="Enter Icon here.."></Input>
                        <div v-if="form.errors.icon" class="text-red-500 text-sm">
                            {{ form.errors.icon }}
                        </div>
                    </div>
                    <Button type="submit" :disabled="form.processing" class="w-fit">
                        <Spinner v-if="form.processing" />
                        Submit
                    </Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
