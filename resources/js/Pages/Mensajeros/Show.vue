<template>
    <Head :title="mensajero.nombre" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ mensajero.nombre }}
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-slate-600 sm:rounded-lg">
                    <div class="grid gap-4 p-6 sm:grid-cols-3">
                        <div class="p-4 bg-gray-400 border border-gray-800 rounded-md dark:bg-slate-700">
                            <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">Perfil</h1>
                            <form @submit.prevent="submit">
                                <div class="mt-4">
                                    <InputLabel for="nombre" value="Nombre:" class="text-gray-300" />
                                    <TextInput id="nombre" type="text" class="block w-full mt-1"
                                        placeholder="ej: John Smith" required v-model="form.nombre" />
                                    <InputError class="mt-2" :message="form.errors.nombre" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="telefono" value="Teléfono:" class="text-gray-300" />
                                    <TextInput id="telefono" type="tel" class="block w-full mt-1" required
                                        v-model="form.telefono" />
                                    <InputError class="mt-2" :message="form.errors.telefono" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="comision" value="Comisión:" class="text-gray-300" />
                                    <TextInput id="comision" type="number" class="block w-full mt-1" placeholder="0.00"
                                        v-model="form.comision" />
                                    <InputError class="mt-2" :message="form.errors.salario" />
                                </div>
                                <div class="flex mt-4">
                                    <input type="checkbox" class="w-6 h-6 rounded-full shadow" name="tiene_efectivo"
                                        id="tiene_efectivo" v-model="form.tiene_efectivo" :true-value="1" :false-value="0">
                                    <InputLabel for="tiene_efectivo" class="flex flex-col justify-center px-2 text-gray-300"
                                        value="Tiene efectivo?" />
                                </div>
                                <div class="flex justify-end mt-4">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                        type="submit">Guardar</PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div class="p-4 bg-gray-400 border border-gray-800 rounded-md sm:col-span-2 dark:bg-slate-700">
                            <h1 class="mb-2 text-2xl font-bold text-center text-gray-600 dark:text-gray-200">Resumen</h1>
                            <div class="grid p-4 mb-2 rounded-md sm:grid-cols-3 dark:bg-slate-600">
                                <h2 class="text-xl font-bold sm:col-span-3 dark:text-gray-300">Entregas</h2>
                                <h5 class="text-lg font-semibold dark:text-gray-300 sm:text-center">Pendientes: {{
                                    pendientes }}</h5>
                                <h5 class="text-lg font-semibold dark:text-gray-300 sm:text-center">Por cobrar: ${{
                                    cobroPendiente }}</h5>
                                <h5 class="text-lg font-semibold dark:text-gray-300 sm:text-center">Comisión de hoy: ${{
                                    cobroHoy }}</h5>
                            </div>
                            <div class="p-4 rounded-md dark:bg-slate-600">
                                <div>
                                    <h2 class="mb-2 text-xl font-bold sm:col-span-3 dark:text-gray-300">Efectivo</h2>
                                    <table class="w-full dark:text-gray-300">
                                        <thead class="uppercase dark:bg-slate-700 dark:text-gray-300">
                                            <th>Moneda</th>
                                            <th>a entregar (cobro incluido)</th>
                                            <th>Efectivo restante</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="efectivo in props.efectivo" :key="efectivo.id"
                                                class="border-b border-gray-800">
                                                <td class="font-semibold text-center">{{ efectivo.nombre }}</td>
                                                <td class="text-right">{{ efectivo.cantidadPorEntregar }}</td>
                                                <td class="text-right">{{ efectivo.cantidadEnCaja }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="mensajero.tiene_efectivo" class="mt-4">
                                    <h2 class="mb-2 text-xl font-bold sm:col-span-3 dark:text-gray-300">Última Asignación</h2>
                                    <table class="w-full dark:text-gray-300">
                                        <thead class="uppercase dark:bg-slate-700 dark:text-gray-300">
                                            <th>Moneda</th>
                                            <th>Cantidad</th>
                                            <th>Fecha</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="asignacion in props.ultimaAsignacion" :key="asignacion.id"
                                                class="border-b border-gray-800">
                                                <td class="font-semibold text-center">{{ asignacion.nombre }}</td>
                                                <td class="text-right">{{ asignacion.asignacion.cantidad }}</td>
                                                <td class="text-right">{{ dayjs(asignacion.asignacion.created_at).format('DD/MM/YYYY') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="mensajero.tiene_efectivo" class="px-6">
                        <div class="p-4 bg-gray-400 border border-gray-800 rounded-md dark:bg-slate-700">
                            <div class="flex justify-end">
                                <EfectivoMensajeroComponent :mensajero="mensajero" :monedas="monedas" />
                            </div>
                        </div>
                    </div>
                    <RemesasComponent :remesas="remesas" :pagination="pagination" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RemesasComponent from '@/Components/RemesasComponent.vue';
import EfectivoMensajeroComponent from '@/Components/EfectivoMensajeroComponent.vue';
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    mensajero: {
        type: Object,
        default: () => ({})
    },
    remesas: {
        type: Object,
        default: () => ({})
    },
    pagination: {
        type: Object,
        default: () => ({})
    },
    monedas: null,
    pendientes: null,
    cobroHoy: null,
    cobroPendiente: null,
    efectivo: null,
    ultimaAsignacion: null,
})

const form = useForm({
    nombre: props.mensajero.nombre,
    telefono: props.mensajero.telefono,
    comision: props.mensajero.comision,
    tiene_efectivo: props.mensajero.tiene_efectivo,
})

const submit = () => {
    // console.log('Acabo de envier el formulario!!')    
    // console.log(form)
    form.put(route('mensajeros.update', props.mensajero.id))
    // form.reset()
    // close()
}

// console.log(props.ultimaAsignacion)
</script>