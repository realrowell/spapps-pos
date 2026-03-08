<script setup lang="ts">
import type {
  ColumnDef,
  ColumnFiltersState,
  ExpandedState,
  SortingState,
  VisibilityState,
} from '@tanstack/vue-table'
import {
  FlexRender,
  getCoreRowModel,
  getExpandedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from '@tanstack/vue-table'
import { createReusableTemplate } from '@vueuse/core'
import { ArrowUpDown, ChevronDown, MoreHorizontal } from 'lucide-vue-next'
import { computed } from "vue"
import { h, ref } from 'vue'
import Badge from '@/components/ui/badge/Badge.vue'

import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Sale } from '@/types/sale/sale'
import formatToCurrency from '@/composables/point-of-sale/formatToCurrency';

function valueUpdater<T>(updaterOrValue: T | ((prev: T) => T), ref: { value: T }): void {
  ref.value = typeof updaterOrValue === 'function' ? (updaterOrValue as (prev: T) => T)(ref.value) : updaterOrValue
}

const props = defineProps<{
    data?: Sale[]
}>()

const [DefineTemplate, ReuseTemplate] = createReusableTemplate<{
    sale: {
        sale_ref: string
    }
    onExpand: () => void
}>()

const statusMap: Record<string, { label: string; variant: string }> = {
    partial: {
        label: "Partial",
        variant: "subtlePrimary",
    },
    completed: {
        label: "Completed",
        variant: "subtleSuccess",
    },
    cancelled: {
        label: "Cancelled",
        variant: "subtleDanger",
    },
    refunded: {
        label: "Refunded",
        variant: "outline",
    },
    paid: {
        label: "Paid",
        variant: "subtleSuccess"
    },
    void: {
        label: "Void",
        variant: "subtleDanger"
    },
}

const columns: ColumnDef<Sale>[] = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
        }),
        cell: ({ row }) => h(Checkbox, {
            'modelValue': row.getIsSelected(),
            'onUpdate:modelValue': value => row.toggleSelected(!!value),
            'ariaLabel': 'Select row',
        }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'sale_ref',
        header: 'Ref. No.',
        cell: ({ row }) => h('div', { class: 'capitalize' },  row.getValue('sale_ref')),
    },
    {
        accessorKey: 'total_amount',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Total Amount', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const total_amount = row.original.total_amount

            return h(
                'div',
                formatToCurrency(total_amount)
            )
        },
    },
    {
        accessorKey: 'payment_status',
        // header: () => h('div', { class: 'capitalize' }, 'Status'),
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Status', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const status = row.getValue('payment_status') as string
            const config = statusMap[status] ?? {
                label: status,
                variant: "secondary"
            }

            return h(
                Badge,
                {
                    variant: config.variant as any
                },
                () => config.label
            )
        }
    },
    {
        accessorKey: 'status',
        // header: () => h('div', { class: 'capitalize' }, 'Status'),
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Status', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const status = row.getValue('status') as string
            const config = statusMap[status] ?? {
                label: status,
                variant: "secondary"
            }

            return h(
                Badge,
                {
                    variant: config.variant as any
                },
                () => config.label
            )
        }
    },
    {
        id: 'actions',
        header: "Action",
        enableHiding: false,
        cell: ({ row }) => {
            const sale = row.original

            return h(ReuseTemplate, {
                sale,
                onExpand: row.toggleExpanded,
            })
        },
    },
]
const safeData = computed(() => props.data ?? [])

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable({
    data: safeData,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get expanded() { return expanded.value },
    },
})

function copy(id: string) {
    navigator.clipboard.writeText(id)
}
</script>

<template>
    <DefineTemplate v-slot="{ sale }">
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="ghost" class="h-8 w-8 p-0">
                    <span class="sr-only">Open menu</span>
                    <MoreHorizontal class="h-4 w-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                    <DropdownMenuItem @click="copy(sale.sale_ref)">
                        Copy sale ID
                    </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>View customer</DropdownMenuItem>
                <DropdownMenuItem>View sale details</DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </DefineTemplate>
    <div class="w-full p-5">
        <div class="flex items-center py-4">
        <Input
            class="max-w-sm"
            placeholder="Filter brand..."
            :model-value="table.getColumn('sale_name')?.getFilterValue() as string"
            @update:model-value=" table.getColumn('sale_name')?.setFilterValue($event)"
        />
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
            <Button variant="outline" class="ml-auto">
                Columns <ChevronDown class="ml-2 h-4 w-4" />
            </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
            <DropdownMenuCheckboxItem
                v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                :key="column.id"
                class="capitalize"
                :model-value="column.getIsVisible()"
                @update:model-value="(value) => {
                column.toggleVisibility(!!value)
                }"
            >
                {{ column.id }}
            </DropdownMenuCheckboxItem>
            </DropdownMenuContent>
        </DropdownMenu>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                        <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                        <TableRow :data-state="row.getIsSelected() && 'selected'">
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="row.getIsExpanded()">
                            <TableCell :colspan="row.getAllCells().length">
                            {{ JSON.stringify(row.original) }}
                            </TableCell>
                        </TableRow>
                        </template>
                    </template>

                    <TableRow v-else>
                        <TableCell
                        :colspan="columns.length"
                        class="h-24 text-center"
                        >
                        No results.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="flex-1 text-sm text-muted-foreground">
                {{ table.getFilteredSelectedRowModel().rows.length }} of
                {{ table.getFilteredRowModel().rows.length }} row(s) selected.
            </div>
            <div class="space-x-2">
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()"
                >
                    Previous
                </Button>
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!table.getCanNextPage()"
                    @click="table.nextPage()"
                >
                    Next
                </Button>
            </div>
        </div>
    </div>
</template>
