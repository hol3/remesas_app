<template>
    <Head title="Mensajeros"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mensajeros
            </h2>
        </template>
        <MensajeroForm @close="openModal" :modal-active="modalActive"/>    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-wrap overflow-hidden">
                    <div class="flex justify-end p-4 min-w-full">
                        <PrimaryButton @click="openModal">Agregar mensajero</PrimaryButton>
                    </div>
                    <div class="flex p-4 justify-center items-center min-w-full">
                        <div class="grid gap-4 sm:grid-cols-4 bg-white p-4 shadow-lg sm:rounded-lg">
                            <div v-for="mensajero in props.mensajeros" :key="mensajero.id">
                                <CardComponent :profile="mensajero" />
                            </div>
                        </div>
                    </div>                                      
                </div>                
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import MensajeroForm from '@/Components/MensajeroForm.vue';
import CardComponent from '@/Components/CardComponent.vue';

const modalActive = ref(false)

const props = defineProps({
    mensajeros: {
        type: Object,
        default: () => ({})
    }
})

const init = () => {
    console.log(props.mensajeros)
}

init()

const openModal = () => {
    modalActive.value = !modalActive.value
}
</script>