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
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
defineProps<{
  open: boolean
}>()

const emit = defineEmits(['update:open'])

</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="min-w-100">
            <DialogHeader>
            <DialogTitle>Edit profile</DialogTitle>
            <DialogDescription>
                Make changes to your profile here. Click save when you're
                done.
            </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4">
            <div class="grid gap-3">
                <Label for="name-1">Name</Label>
                <Input id="name-1" name="name" default-value="Pedro Duarte" />
            </div>
            <div class="grid gap-3">
                <Label for="username-1">Username</Label>
                <Input id="username-1" name="username" default-value="@peduarte" />
            </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
