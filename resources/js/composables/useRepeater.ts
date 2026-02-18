import { ref } from 'vue'

export function useRepeater<T extends Record<string, any>>(initialValue: T) {

    // Let Vue infer type, then cast safely
    const items = ref([structuredClone(initialValue)]) as unknown as { value: T[] }

    function add(item?: Partial<T>) {
        items.value.push({
            ...structuredClone(initialValue),
            ...item,
        })
    }

    function remove(index: number) {
        if (items.value.length > 1) {
            items.value.splice(index, 1)
        }
    }

    function clear() {
        items.value = [structuredClone(initialValue)]
    }

    return {
        items,
        add,
        remove,
        clear,
    }
}
