import { onMounted, nextTick } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { toast  } from '@/components/ui/sonner'

export function useFlashToast() {
    const page = usePage()

    onMounted(() => {
            const flash = page.props.flash as {
            success?: string
            error?: string
            info?: string
            warning?: string
        }

        if (flash?.success) {
            toast.success(flash.success)
        }

        if (flash?.error) {
            toast.error(flash.error)
        }

        if (flash?.info) {
            toast.info(flash.info)
        }

        if (flash?.warning) {
            toast.warning(flash.warning)
        }
    })
}
