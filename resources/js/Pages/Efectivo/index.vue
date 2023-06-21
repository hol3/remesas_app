<template>
    <Head title="Caja" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Efectivo en caja
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mx-auto border p-2 rounded-lg shadow-md max-w-3xl">
                            <form @submit.prevent="submit">
                                <div class="mt-2">
                                    <h3 class="text-sm font-semibold">Efectivo en caja:</h3>
                                    <p class="py-1 font-light">En este formulario se agrega el efectivo despues de recoger dinero para las entregas. Se debe poner el monto real que se tiene en caja de todas las monedas.</p>
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:space-x-2">
                                        <TextInput id="cantidad" type="number" class="mt-1 block" required v-model="form.cantidad" placeholder="Cantidad"/>
                                        <select v-model="form.moneda_id" id="monedas"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                            <option v-for="moneda in monedas" v-bind:value="moneda.id">{{
                                                moneda.nombre
                                            }}</option>
                                        </select>
                                        <PrimaryButton class="mt-4 sm:mt-1">Guardar</PrimaryButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table-auto mt-4 table mx-auto min-w-full">
                            <thead class="table-header-group border bg-gray-200 shadow-lg text-center">
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Moneda</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="dinero in efectivo" class="border">
                                    <td class="table-cell">{{ dinero.cantidad }}</td>
                                    <td class="table-cell">{{ dinero.moneda }}</td>
                                    <td class="table-cell">{{ dayjs(dinero.created_at).format('DD/MM/YYYY') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>    
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

defineProps({
    efectivo: {
        type: Object,
        default: () => ({})
    },
    monedas: {
        type: Object,
        default: () => ({})
    }
})

dayjs.extend(relativeTime)

const form = useForm({
    id: '',
    cantidad: '',
    moneda_id: ''
})

let isEdit = false
let Id

const submit = () => {
    console.log(form)
    if (isEdit) {
        console.log(Id)
        form.put(route('dinero.update', Id))
        form.reset()
        isEdit = false
    }else{
        form.post(route('dinero.store'))
        form.reset()
    }    
}

const edit = (id, cantidad, moneda_id) => {
    console.log('le di click a: ' + id)
    isEdit = true
    Id = id
    form.id = id 
    form.cantidad = cantidad
    form.moneda_id = moneda_id
}
</script>