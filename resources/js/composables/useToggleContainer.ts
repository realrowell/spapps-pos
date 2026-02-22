import { ref, type Ref } from 'vue'

export function useToggleContainer(initial = false) {
  const isChecked = ref(initial)

  const toggle = () => {
    isChecked.value = !isChecked.value
  }

  return {
    isChecked,
    toggle
  }
}

/**
 * Use multiple toggle states in a reactive map
 * @param initial Object with keys as toggle names and boolean default values
 */
export function useToggleContainerMap(initial: Record<string, boolean>) {
  // Make a reactive map
  const map: Ref<Record<string, boolean>> = ref({ ...initial })

  // Toggle a key
  const toggle = (key: string) => {
    if (key in map.value) {
      map.value[key] = !map.value[key]
    }
  }

  return { map, toggle }
}
