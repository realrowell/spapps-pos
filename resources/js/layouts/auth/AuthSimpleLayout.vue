<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import HeroLoginImage from '@/components/ui/HeroLoginImage.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 bg-[image:linear-gradient(to_right,rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url(/images/hero-image-login.jpg)] bg-cover"
    >
        <div class="w-250 bg-white rounded-2xl flex flex-row shadow-2xl ">
            <div class="flex flex-col gap-8 p-6 md:p-10 flex-1">
                <div class="flex flex-col items-center gap-4">
                    <Link
                        :href="home()"
                        class="flex flex-row items-center gap-2 font-medium"
                    >
                        <div
                            class="mb-1 flex h-9 w-9 items-center justify-center rounded-md"
                        >
                            <AppLogoIcon
                                class="size-9 fill-current text-(--app-primary-color) dark:text-white"
                            />
                        </div>
                        <h1 class="text-2xl text-(--app-primary-color)">SP Apps POS</h1>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-lg font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <slot />
            </div>
            <div class="flex flex-col flex-2">
                <div class="h-full ">
                    <HeroLoginImage class="h-full object-cover rounded-r-2xl"/>
                </div>
            </div>
        </div>
    </div>
</template>
