import type { VariantProps } from "class-variance-authority"
import { cva } from "class-variance-authority"

export { default as Button } from "./Button.vue"

export const buttonVariants = cva(
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive",
    {
    variants: {
        variant: {
            default: "bg-(--app-primary-color) text-white hover:bg-(--app-dark-primary-color) hover:cursor-pointer active:bg-(--app-dark-primary-color)/80",
            destructive: "bg-destructive text-white hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60",
            outline: "border bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 hover:cursor-pointer",
            secondary: "bg-(--app-secondary-color) text-black hover:bg-(--app-dark-secondary-color) hover:cursor-pointer active:bg-(--app-dark-secondary-color)/80",
            ghost: "hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 hover:cursor-pointer",
            link: "text-primary underline-offset-4 hover:underline hover:cursor-pointer",
            danger: "bg-(--app-danger-color) text-white hover:bg-(--app-dark-danger-color) hover:cursor-pointer active:bg-(--app-dark-danger-color)/80",
            success: "bg-(--app-success-color) text-white hover:bg-(--app-dark-success-color) hover:cursor-pointer active:bg-(--app-dark-success-color)/80",
            warning: "bg-(--app-warning-color) text-white hover:bg-(--app-dark-warning-color) hover:cursor-pointer active:bg-(--app-dark-warning-color)/80",
            light: "bg-white text-black hover:bg-neutral-100 hover:cursor-pointer",
            dark: "bg-black text-white hover:bg-neutral-800 hover:cursor-pointer",
            subtlePrimary: "bg-(--app-subtle-primary-color) text-(--app-primary-color) hover:bg-(--app-primary-color) hover:text-white hover:cursor-pointer active:bg-(--app-dark-primary-color)/80",
            subtleSecondary: "bg-(--app-subtle-secondary-color) text-(--app-secondary-color) hover:bg-(--app-secondary-color) hover:text-black hover:cursor-pointer active:bg-(--app-dark-secondary-color)/80",
            subtleDanger: "bg-(--app-subtle-danger-color) text-(--app-danger-color) hover:bg-(--app-danger-color) hover:text-white hover:cursor-pointer active:bg-(--app-dark-danger-color)/80",
            subtleSuccess: "bg-(--app-subtle-success-color) text-(--app-success-color) hover:bg-(--app-success-color) hover:text-white hover:cursor-pointer active:bg-(--app-dark-success-color)/80",
            subtleWarning: "bg-(--app-subtle-warning-color) text-(--app-warning-color) hover:bg-(--app-warning-color) hover:text-white hover:cursor-pointer active:bg-(--app-dark-warning-color)/80",
        },
        size: {
            "default": "h-9 px-4 py-2 has-[>svg]:px-3",
            "sm": "h-8 rounded-md gap-1.5 px-3 has-[>svg]:px-2.5",
            "lg": "h-10 rounded-md px-6 has-[>svg]:px-4",
            "icon": "size-9",
            "icon-sm": "size-8",
            "icon-lg": "size-10",
        },
    },
    defaultVariants: {
        variant: "default",
        size: "default",
    },
    },
)
export type ButtonVariants = VariantProps<typeof buttonVariants>
