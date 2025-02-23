<script setup>
import ContabForm from '@/Components/ContabForm.vue';
import ModalDialog from '@/Components/ModalDialog.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import dayjs from 'dayjs';
import { ref } from 'vue';

const props = defineProps({
    efectivo: Object,
    monedas: Object,
    estados: Object
});
console.log(props.efectivo);
const dialogActive = ref(false);

const showDialog = () => {
    dialogActive.value = !dialogActive.value;
}
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Contabilidad
            </h2>
        </template>
        <ModalDialog @close="showDialog" :modal-active="dialogActive">
            <template #title>
                <h3 class="mr-6 text-2xl">Agregar Efectivo</h3>
            </template>
            <template #content>
                <ContabForm @close="showDialog" :efectivo="efectivo" :monedas="monedas" :estados="estados"/>
            </template>
        </ModalDialog>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-end">
                    <PrimaryButton @click="showDialog">Agregar efectivo</PrimaryButton>
                </div>
                <div class="p-6 mt-2 bg-white shadow-sm dark:bg-slate-600 sm:rounded-lg">
                    <!-- tabla                     -->
                    <table class="w-full my-4 text-sm text-left text-gray-500 dark:text-gray-200">
                        <thead class="text-xs text-center uppercase bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="table-cell py-3">Cantidad</th>
                                <th class="table-cell">Moneda</th>
                                <th class="table-cell">Entrada/Salida</th>
                                <th class="hidden sm:table-cell">Nota</th>
                                <th class="hidden sm:table-cell">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dinero in efectivo.data" :key="dinero.id"
                                class="border-b dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <td class="table-cell py-2 text-right">{{ dinero.cantidad }}</td>
                                <td class="table-cell text-center">{{ dinero.moneda.nombre }}</td>
                                <td class="table-cell text-center">
                                    <span :class="(estado = (dinero.concepto == 'entrada')
                                        ? 'uppercase text-xs font-semibold bg-green-700 px-2 py-1 rounded-full' :
                                        (dinero.concepto == 'salida')
                                        ? 'uppercase text-xs font-semibold bg-red-700 px-2 py-1 rounded-full' : 'uppercase font-semibold'
                                    )">
                                        {{ dinero.concepto }}
                                    </span>
                                </td>
                                <td class="hidden text-center sm:table-cell">{{ dinero.nota }}</td>
                                <td class="hidden text-center sm:table-cell">{{ dayjs(dinero.created_at).format("DD MMM YYYY") }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
