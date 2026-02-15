<script setup lang="ts">
import type {
    ColumnDef,
} from "@tanstack/vue-table"
import {
    getCoreRowModel,
    useVueTable,
    FlexRender,
} from "@tanstack/vue-table"

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"

interface Category {
  cat_code: string
  cat_name: string
  is_active: string
}

const props = defineProps<{
    data: Category[]
}>()

console.log(props)

const columns: ColumnDef<Category>[] = [
    {
        accessorKey: "cat_code",
        header: "ID",
    },
    {
        accessorKey: "cat_name",
        header: "Name",
    },
    {
        accessorKey: "is_active",
        header: "is Active",
    },
]

const table = useVueTable({
    data: props.data,
    columns,
    getCoreRowModel: getCoreRowModel(),
})
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <TableHead
                    v-for="header in headerGroup.headers"
                    :key="header.id"
                >
                    <FlexRender
                        :render="header.column.columnDef.header"
                        :props="header.getContext()"
                    />
                </TableHead>
            </TableRow>
        </TableHeader>

        <TableBody>
            <TableRow
                v-for="row in table.getRowModel().rows"
                :key="row.id"
            >
                <TableCell
                    v-for="cell in row.getVisibleCells()"
                    :key="cell.id"
                >
                    <FlexRender
                        :render="cell.column.columnDef.cell"
                        :props="cell.getContext()"
                    />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
