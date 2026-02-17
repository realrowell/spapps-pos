<script setup>
import { computed } from 'vue'
import { X } from 'lucide-vue-next'

import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
} from '@/components/ui/select'

const props = defineProps({
    modelValue: {
        type: [String, Number, null],
        default: null,
    },
    placeholder: {
        type: String,
        default: 'Select option',
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    triggerClass: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val),
})

function clear(e) {
    e.stopPropagation()
    emit('update:modelValue', null)
}
</script>

<template>
    <Select v-model="value">
        <SelectTrigger
            :class="['flex justify-between items-center', triggerClass]"
        >
            <SelectValue :placeholder="placeholder" />

            <X
                v-if="clearable && value"
                class="w-4 h-4 text-muted-foreground hover:text-destructive cursor-pointer"
                @click="clear"
            />
        </SelectTrigger>

        <SelectContent>
            <slot />
        </SelectContent>
    </Select>
</template>
