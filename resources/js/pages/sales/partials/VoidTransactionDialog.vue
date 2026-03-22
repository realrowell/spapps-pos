<script setup lang="ts">
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
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
import { salePointOfSaleVoidSale } from '@/routes';
import { Sale } from '@/types/sale/sale';

const { sale_order } = defineProps<{
    sale_order: Sale
}>()

const voidSale = () => {
    router.post(
        salePointOfSaleVoidSale(sale_order.sale_ref),
        {},
        {
            onSuccess: () => {
                console.log('Sale voided')
            }
        }
    )
}
</script>
<template>
    <Dialog>
        <DialogTrigger>
            <Button
                class="w-full"
                variant="danger"
                type="button"
                >
                <!-- <Spinner v-if="voidSale.processing" /> -->
                Void Transaction
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle> </DialogTitle>
            </DialogHeader>
            <div class="flex flex-col gap-3 p-10">
                <div class="flex flex-row justify-center align-center">
                    <h3 class="text-2xl">Confirm Void Transaction</h3>
                </div>
            </div>
            <div class="flex flex-row justify-between">
                <DialogClose as-child>
                    <Button
                        variant="outline"
                        type="button" >
                        Cancel
                    </Button>
                </DialogClose>
                <Button
                    @click="voidSale"
                    variant="danger"
                    type="button">
                    Confirm
                </Button>
            </div>
        </DialogContent>
    </Dialog>

</template>
