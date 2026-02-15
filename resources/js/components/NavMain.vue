<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import {
  SidebarMenu,
  SidebarMenuItem,
  SidebarMenuButton,
} from '@/components/ui/sidebar'
import type { NavItem } from '@/types'

defineProps<{
  items: NavItem[]
}>()

const page = usePage()
const openMenus = ref<string[]>([])

function toggle(title: string) {
  if (openMenus.value.includes(title)) {
    openMenus.value = openMenus.value.filter(t => t !== title)
  } else {
    openMenus.value.push(title)
  }
}

function isChildActive(children: NavItem[]) {
  return children.some(child => {
    const href = typeof child.href === 'string' ? child.href : child.href?.url
    return href && page.url.startsWith(new URL(href, window.location.origin).pathname)
  })
}

function isActive(href?: string) {
  if (!href) return false

  const url = new URL(href, window.location.origin)
  return page.url.startsWith(url.pathname)
}
</script>

<template>
    <SidebarMenu>
        <template v-for="item in items" :key="item.title">

            <!-- Normal Item -->
            <SidebarMenuItem v-if="!item.children">
                <SidebarMenuButton
                    as-child
                    :is-active="isActive(typeof item.href === 'string' ? item.href : item.href?.url)"
                    :class="{ 'bg-(--app-primary-color) text-white': isActive(typeof item.href === 'string' ? item.href : item.href?.url) } "
                    class="hover:bg-(--app-primary-color) hover:text-white"
                >
                    <Link :href="item.href!">
                        <component :is="item.icon" class="w-4 h-4 mr-2" />
                        {{ item.title }}
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <!-- Item With Children -->
            <SidebarMenuItem v-else>
                <SidebarMenuButton
                    @click="toggle(item.title)"
                    :class="{ 'bg-(--app-primary-color) text-white': isChildActive(item.children) } "
                    class=" hover:cursor-pointer hover:bg-(--app-primary-color) hover:text-white"
                >
                    <component :is="item.icon" class="w-4 h-4 mr-2" />
                    {{ item.title }}
                </SidebarMenuButton>

                <div
                    v-if="openMenus.includes(item.title) || isChildActive(item.children)"
                    class="ml-6 mt-1 space-y-1"
                >
                    <Link
                    v-for="child in item.children"
                    :key="child.title"
                    :href="child.href!"
                    :class="{ 'bg-(--app-primary-color) text-white': isActive(typeof child.href === 'string' ? child.href : child.href?.url) } "
                    class="block px-2 py-1 text-sm rounded-md hover:bg-(--app-primary-color) hover:text-white"
                    >
                    {{ child.title }}
                    </Link>
                </div>
            </SidebarMenuItem>

        </template>
    </SidebarMenu>
</template>
