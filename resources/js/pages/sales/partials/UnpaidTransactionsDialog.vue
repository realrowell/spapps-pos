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
import { Link } from '@inertiajs/vue3'
import { salePointOfSalePaymentShow } from '@/routes'
import formatDate from '@/composables/formatDate'

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
                            <TableHead>Items</TableHead>
                            <TableHead>Unpaid Amount</TableHead>
                            <TableHead>Total Amount</TableHead>
                            <TableHead>Timestamp</TableHead>
                            <TableHead class="text-right">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="sale in props.sales" :key="sale.sale_ref">
                            <TableCell class="font-medium">{{ sale.sale_ref }}</TableCell>
                            <TableCell>{{ sale.status }}</TableCell>
                            <TableCell>{{ sale.sale_items?.length }}</TableCell>
                            <TableCell class="bg-red-200 text-red-600">
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
                            <!-- <TableCell>{{ sale.created_at.toLocaleString() }}</TableCell> -->
                            <TableCell>
                                {{
                                    formatDate(sale.created_at)
                                }}
                            </TableCell>
                            <TableCell class="text-right">
                                <Link :href="salePointOfSalePaymentShow(sale.sale_ref)"><Button type="button" size="sm">Pay</Button></Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableFooter>
                        <TableRow>
                            <TableCell colspan="5">
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
