<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline';

const emit = defineEmits(["close"]);

const props = defineProps({
    modalActive: Boolean,
});

const close = () => {
    emit("close");
}
</script>
<template>
    <div v-show="modalActive" class="fixed inset-0 flex items-center self-center justify-center h-screen bg-gray-500 bg-opacity-50 backdrop-blur-sm">
        <div class="max-w-2xl p-4 bg-white rounded-md shadow">
            <div class="flex items-center justify-between p-2 border-b-2">
                <slot name="title"/>
                <XMarkIcon class="size-6" @click="close"/>
            </div>
            <div class="p-2">
                <slot name="content"/>
            </div>
        </div>
    </div>
</template>
