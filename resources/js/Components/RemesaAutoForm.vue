<template>
    <div v-show="formActive" class="fixed inset-0 flex items-center self-center justify-center bg-gray-700 bg-opacity-50 backdrop-blur-sm">
        <div class="w-[640px] max-w-2xl h-4/5 overflow-auto lg:h-auto bg-white rounded-md shadow-sm p-4">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl mr-6">Nuevo Formulario (Beta)</h3>
                <IconX @click="close"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { IconX } from '@tabler/icons-vue'
import InputLabel from './InputLabel.vue';
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    formActive: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['close'])

const close = () => {
    emit('close')
}
</script>