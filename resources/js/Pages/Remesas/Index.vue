<template>
    <Head title="Remesas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Remesas
            </h2>
        </template>
        <RemesasForm @close="showForm" :form-active="formActive" :provincias="props.provincias" :monedas="props.monedas" :mensajeros="props.mensajeros" />    
        <RemesaAutoForm @close="showAutoForm" :form-active="autoFormActive" :provincias="props.provincias" :monedas="props.monedas" :mensajeros="props.mensajeros" />    
        <!-- Listado de Remesas -->
        <div class="py-12">            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4 gap-2">
                    <PrimaryButton @click="showForm">Nueva entrega</PrimaryButton>
                    <PrimaryButton @click="showAutoForm">Nueva entrega auto</PrimaryButton>
                </div>
                <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <RemesasComponent :remesas="remesas" :pagination="pagination" />
                </div>                
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import dayjs from 'dayjs';
import relativeTime from "dayjs/plugin/relativeTime";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RemesasComponent from '@/Components/RemesasComponent.vue';
import RemesasForm from '@/Components/RemesasForm.vue';
import RemesaAutoForm from '@/Components/RemesaAutoForm.vue';
import { ref } from 'vue';

dayjs.extend(relativeTime)

const props = defineProps({
    remesas: {
        type: Object,
        default: () => ({})
    },    
    pagination: {
        type: Object,
        default: () => ({})
    },
    provincias: null,
    monedas: null,
    mensajeros: null,
})


const formActive = ref(false)
const autoFormActive = ref(false)

const form = useForm({
    codigo: '',
    nombre_cliente: '',
    telefono: '',
    direccion: '',
    municipio_id: '',
    cantidad: '',
    moneda_id: '',
    comision: '',
    mensajero_id: '',
})

const showForm = () => {
    // remesa = data
    formActive.value = !formActive.value
    // console.log(remesa)
}

const showAutoForm = () => {
    // remesa = data
    autoFormActive.value = !autoFormActive.value
    // console.log(remesa)
}

// const submit = () => {
//     form.post(route('remesas.store'))
//     console.log(form)
//     form.reset()    
// }

// function destroy(id) {
//     if (confirm("Esta seguro que desea eliminar la remesa?")) {
//         form.delete(route('remesas.destroy', id))
//     }
// }



</script>