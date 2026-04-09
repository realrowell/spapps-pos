<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  NumberField,
  NumberFieldContent,
  NumberFieldDecrement,
  NumberFieldIncrement,
  NumberFieldInput,
} from '@/components/ui/number-field'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';
import { Link, useForm } from '@inertiajs/vue3'
import { inventoryProductPriceStore } from '@/routes'
import formatDate from '@/composables/formatDate'
import type { Product } from '@/types/inventories/product';
import clearSelect from '@/composables/clearSelectOption';
import Spinner from '@/components/ui/spinner/Spinner.vue';

const props = defineProps<{
    open: boolean
    product: Product
    price_types: any
}>()

const emit = defineEmits(['update:open'])

const form = useForm({
    product_id: props.product.pr_code,
    price_type: '',
    price: 0,
    price_effective_from: '',
    price_effective_to: '',
})

const onSubmit = () => {
    form.post(inventoryProductPriceStore().url, {
        onSuccess: () => {
            form.reset()
            emit('update:open', false)
        },
        onError: (errors) => {
            console.log(errors)
        }
    })
}
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="min-w-200">
            <DialogHeader>
                <DialogTitle>Create Pricing</DialogTitle>
                <DialogDescription>
                    Make changes to your profile here. Click save when you're
                    done.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 max-h-150 overflow-y-auto">
                <form @submit.prevent="onSubmit" class="flex flex-col gap-5">
                    <div class="flex flex-row gap-3">
                        <div class="flex flex-col gap-3">
                            <Label for="price_type">Price Type</Label>
                            <div class="flex flex-row gap-1 w-50">
                                <Select v-model="form.price_type">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select price type" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Price Type</SelectLabel>
                                            <SelectItem v-for="(label, value) in price_types" :key="value" :value="value">
                                                {{ label  }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <Button
                                    variant="outline"
                                    @click="clearSelect('price_type', form)"
                                    v-if="form.price_type"
                                >
                                    Clear
                                </Button>
                            </div>
                            <div v-if="form.errors.price_type" class="text-red-500 text-sm">
                                {{ form.errors.price_type }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <Label for="price">Price</Label>
                            <NumberField
                                v-model="form.price"
                                id="price"
                                :min="0"
                                :default-value="1.00"
                                :format-options="{
                                    style: 'currency',
                                    currency: 'PHP',
                                    currencyDisplay: 'code',
                                    currencySign: 'accounting',
                                }"
                            >
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                            <div v-if="form.errors.price" class="text-red-500 text-sm">
                                {{ form.errors.price }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex flex-col gap-3">
                            <Label for="effective_date">Effective from</Label>
                            <Input class="w-50" id="effective_date" type="date" v-model="form.price_effective_from" />
                            <div v-if="form.errors.price_effective_from" class="text-red-500 text-sm">
                                {{ form.errors.price_effective_from }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <Label for="effective_date">Effective to</Label>
                            <Input class="w-50" id="effective_date" type="date" v-model="form.price_effective_to" />
                            <div v-if="form.errors.price_effective_to" class="text-red-500 text-sm">
                                {{ form.errors.price_effective_to }}
                            </div>
                        </div>
                    </div>
                    <Button type="submit" :disabled="form.processing" class="w-fit">
                        <Spinner v-if="form.processing" />
                        Submit
                    </Button>
                </form>
            </div>
        </DialogContent>
    </Dialog>
</template>
