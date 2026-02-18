<script setup lang="ts">
import {
    CalendarDate,
    parseDate,
    getLocalTimeZone
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { ref, watch } from 'vue'
import { Button } from '@/components/ui/button'
import { Calendar } from '@/components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { cn } from '@/lib/utils'


const props = defineProps<{
    modelValue: string | null
    placeholder?: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void
}>()

// ✅ use CalendarDate, NOT Date
const selectedDate = ref<CalendarDate | undefined>(
    props.modelValue ? parseDate(props.modelValue) : undefined
)

watch(selectedDate, (date) => {
    emit('update:modelValue', date ? date.toString() : null)
})
</script>

<template>
<Popover>

    <PopoverTrigger as-child>
        <Button
            variant="outline"
            :class="cn(
                'min-w-[180px] w-fit justify-start text-left font-normal',
                !selectedDate && 'text-muted-foreground'
            )"
        >
            <CalendarIcon class="mr-2 h-4 w-4" />

            {{
                selectedDate
                ? selectedDate.toDate(getLocalTimeZone()).toDateString()
                : placeholder ?? "Pick a date"
            }}

        </Button>
    </PopoverTrigger>

    <PopoverContent class="w-auto p-0">

        <!-- ✅ Correct type -->
        <Calendar v-model="selectedDate" />

    </PopoverContent>

</Popover>
</template>
