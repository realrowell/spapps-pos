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
import { salePaymentProviders, salePaymentProvidersCreate, salePaymentProvidersStore, saleSales } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: saleSales().url,
    },
    {
        title: 'Payment Providers',
        href: salePaymentProviders().url,
    },
    {
        title: 'Create Payment Providers',
        href: salePaymentProvidersCreate().url,
    },
];

const { mops, generatedCode } = defineProps<{
    mops: any;
    generatedCode: string;
}>()

const form = useForm({
    name: '',
    code: generatedCode,
    account_name: '',
    account_no: '',
    mop: '',
})

const submit = () => {
    form.post(salePaymentProvidersStore().url)
}

function clearSelect(path: string) {
    const keys = path.split('.')
    let target: any = form // allow dynamic indexing

    for (let i = 0; i < keys.length - 1; i++) {
        target = target[keys[i]]
        if (!target) return
    }

    target[keys[keys.length - 1]] = null
}
</script>

<template>
    <Head title="Create Payment Providers" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row justify-between align-center">
                <h2 class="text-2xl">Create Payment Providers</h2>
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
                    <div class="flex flex-row gap-5">
                        <div class="flex flex-col justify-start align-center gap-3">
                            <Label for="Name">Provider Name</Label>
                            <Input id="Name" v-model="form.name" placeholder="Enter category name here.."></Input>
                            <div v-if="form.errors.name" class="text-red-500 text-sm">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="flex flex-col justify-start align-center gap-3">
                            <Label for="AccountName">Account Name</Label>
                            <Input id="AccountName" v-model="form.account_name" placeholder="Enter account name here.."></Input>
                            <div v-if="form.errors.account_name" class="text-red-500 text-sm">
                                {{ form.errors.account_name }}
                            </div>
                        </div>
                        <div class="flex flex-col justify-start align-center gap-3">
                            <Label for="AccountNo">Account Number</Label>
                            <Input id="AccountNo" v-model="form.account_no" placeholder="Enter Account No. here.."></Input>
                            <div v-if="form.errors.account_no" class="text-red-500 text-sm">
                                {{ form.errors.account_no }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-start align-center gap-3">
                        <Label for="Mop">Mode of Payment</Label>
                        <div class="flex flex-row gap-1 w-50">
                            <Select v-model="form.mop">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select mode of payment" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Mode of Payments</SelectLabel>
                                        <SelectItem v-for="mop in mops" :key="mop.mop_code" :value="mop.mop_code">
                                            {{ mop.mop_name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <Button
                                variant="outline"
                                @click="clearSelect('mop')"
                                v-if="form.mop"
                            >
                                Clear
                            </Button>
                        </div>
                        <div v-if="form.errors.mop" class="text-red-500 text-sm">
                            {{ form.errors.mop }}
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
