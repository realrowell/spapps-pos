import type { VariantProps } from "class-variance-authority"
import { cva } from "class-variance-authority"

export { default as Badge } from "./Badge.vue"

export const badgeVariants = cva(
  "inline-flex items-center justify-center rounded-full border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden",
  {
    variants: {
        variant: {
            default:
            "border-transparent bg-(--app-primary-color) text-white [a&]:hover:bg-primary/90",
            secondary:
            "border-transparent bg-(--app-secondary-color) text-black [a&]:hover:bg-secondary/90",
            destructive:
            "border-transparent bg-destructive text-white [a&]:hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60",
            outline:
            "text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground",
            success: "border-transparent bg-(--app-success-color) text-white",
            danger: "border-transparent bg-(--app-danger-color) text-white",
            warning: "border-transparent bg-(--app-warning-color) text-white",
            info: "border-transparent bg-(--app-info-color) text-white",
            subtlePrimary: "border-transparent bg-(--app-subtle-primary-color) text-(--app-primary-color)",
            subtleSuccess: "border-transparent bg-(--app-subtle-success-color) text-(--app-success-color)",
            subtleDanger: "border-transparent bg-(--app-subtle-danger-color) text-(--app-danger-color)",
            subtleWarning: "border-transparent bg-(--app-subtle-warning-color) text-(--app-warning-color)",
            subtleInfo: "border-transparent bg-(--app-subtle-info-color) text-(--app-info-color)",
            subtleSecondary: "border-transparent bg-(--app-subtle-secondary-color) text-(--app-secondary-color)",
        },
    },
    defaultVariants: {
      variant: "default",
    },
  },
)
export type BadgeVariants = VariantProps<typeof badgeVariants>
