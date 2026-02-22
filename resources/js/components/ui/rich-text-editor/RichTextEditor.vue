<script setup lang="ts">
import { Link2, Link2Off, List, ListOrdered, Bold, Italic, Underline as IcoUnderline } from 'lucide-vue-next'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import BulletList from '@tiptap/extension-bullet-list'
import OrderedList from '@tiptap/extension-ordered-list'
import ListItem from '@tiptap/extension-list-item'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Heading from '@tiptap/extension-heading'
import Paragraph from '@tiptap/extension-paragraph'
import Placeholder from '@tiptap/extension-placeholder'
import Link from '@tiptap/extension-link'

import { Button } from '@/components/ui/button'
import { onBeforeUnmount, watch } from 'vue'

const props = defineProps<{
    modelValue: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        // StarterKit,
        Underline,
        Placeholder.configure({
            placeholder: 'Write description...'
        }),
        StarterKit.configure({
            bulletList: false,
            orderedList: false,
            listItem: false,
            link: false,
        }),
        BulletList,
        OrderedList,
        ListItem,
        Link.configure({
            openOnClick: false,
            autolink: true,
            defaultProtocol: 'https',
            HTMLAttributes: {
                class: 'text-primary underline cursor-pointer',
            },
        }),
        Paragraph,
        Heading.configure({
          levels: [1, 2, 3],
        }),
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    },
})

watch(() => props.modelValue, (value) => {
    if (editor.value && value !== editor.value.getHTML()) {
        editor.value.commands.setContent(value || '')
    }
})

onBeforeUnmount(() => {
    editor.value?.destroy()
})

function setLink() {
    const instance = editor.value
    if (!instance) return

    const previousUrl = instance.getAttributes('link').href

    const url = window.prompt('Enter URL', previousUrl || 'https://')

    if (url === null) return

    if (url === '') {
        instance.chain().focus().unsetLink().run()
        return
    }

    instance.chain().focus().setLink({ href: url }).run()
}

</script>

<template>
    <div class="border rounded-md">

        <!-- Toolbar -->
        <div class="border-b p-2 flex gap-2 flex-wrap">

            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('heading', { level: 1 }) }"
                title="Heading 1"
            >
                H1
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('heading', { level: 2 }) }"
                title="Heading 2"
            >
                H2
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('heading', { level: 3 }) }"
                title="Heading 3"
            >
                H3
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().setParagraph().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('paragraph') }"
                title="Paragraph"
            >
                P
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleBold().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('bold') }"
                title="Bold"
            >
                <Bold />
            </Button>

            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleItalic().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('italic') }"
                title="Italic"
            >
                <Italic />
            </Button>

            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleUnderline().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('underline') }"
                title="Underline"
            >
                <IcoUnderline />
            </Button>

            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('bulletList') }"
                title="Unordered List"
            >
                <List />
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().toggleOrderedList().run()"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('orderedList') }"
                title="Ordered List"
            >
                <ListOrdered />
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="setLink"
                :disabled="!editor"
                :class="{ 'is-active bg-(--app-primary-color) hover:bg-(--app-dark-primary-color) text-white hover:text-white': editor?.isActive('link') }"
                title="Add link"
            >
                <Link2 />
            </Button>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="editor?.chain().focus().unsetLink().run()"
                :disabled="!editor"
                title="Remove link"
            >
                <Link2Off />
            </Button>

        </div>

        <!-- Editor -->
        <EditorContent
            :editor="editor"
            class="
                p-3
                prose prose-sm max-w-none
                [&_.ProseMirror]:min-h-30
                [&_.ProseMirror]:outline-none
                [&_.ProseMirror]:max-h-150
                [&_.ProseMirror]:overflow-y-auto
            "
        />

    </div>
</template>

<style scoped>
    :deep(.ProseMirror) {
        min-height: 250px;
        outline: none;
    }

    :deep(.ProseMirror ul) {
        list-style-type: disc;
        padding-left: 1.5rem;
    }

    :deep(.ProseMirror ol) {
        list-style-type: decimal;
        padding-left: 1.5rem;
    }

    :deep(.ProseMirror h1) {
        font-size: 1.5rem;
        font-weight: 600;
    }

    :deep(.ProseMirror h2) {
        font-size: 1.25rem;
        font-weight: 600;
    }
</style>
