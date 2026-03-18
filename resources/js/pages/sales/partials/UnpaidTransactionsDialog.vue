<script setup lang="ts">
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
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import type { Sale } from '@/types/sale/sale';
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';

const props = defineProps<{
  open: boolean
  sales: Sale[]
}>()

const emit = defineEmits(['update:open'])

</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="min-w-200">
            <DialogHeader>
                <DialogTitle>Unpaid Transactions</DialogTitle>
                <!-- <DialogDescription>
                    Make changes to your profile here. Click save when you're
                    done.
                </DialogDescription> -->
            </DialogHeader>
            <div class="grid gap-4 max-h-150 overflow-y-auto">
                <Table class="">
                    <TableCaption>A list of your recent invoices.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-25">Sale Ref.</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Method</TableHead>
                            <TableHead>Unpaid Amount</TableHead>
                            <TableHead>Total Amount</TableHead>
                            <TableHead class="text-right">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="sale in props.sales" :key="sale.sale_ref">
                            <TableCell class="font-medium">{{ sale.sale_ref }}</TableCell>
                            <TableCell>{{ sale.status }}</TableCell>
                            <TableCell>{{ sale.sale_payments?.length }}</TableCell>
                            <TableCell>
                                {{
                                    formatToCurrency(
                                    sale.total_amount - (
                                        sale.sale_payments?.reduce((total, payment) => {
                                        return total + Number(payment.amount)
                                        }, 0) || 0
                                    )
                                    )
                                }}
                            </TableCell>
                            <TableCell>{{ formatToCurrency(sale.total_amount) }}</TableCell>
                            <TableCell class="text-right">
                                <Button type="button" size="sm">Pay</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableFooter>
                        <TableRow>
                            <TableCell colspan="3">
                            Total
                            </TableCell>
                            <TableCell class="text-right">
                            $2,500.00
                            </TableCell>
                        </TableRow>
                    </TableFooter>
                </Table>
            </div>
        </DialogContent>
    </Dialog>
</template>
