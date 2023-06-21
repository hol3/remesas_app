<template>
    <Head :title="mensajero.nombre" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ mensajero.nombre }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid sm:grid-cols-3 gap-4 p-6">
                        <div class="bg-gray-400 dark:bg-slate-700 border border-gray-800 p-4 rounded-md">
                            <h1 class="sm:col-span-3 font-bold text-2xl text-gray-600 dark:text-gray-200">Perfil</h1>
                            <form @submit.prevent="submit">
                                <div class="mt-4">
                                    <InputLabel for="nombre" value="Nombre:" class="text-gray-300" />
                                    <TextInput id="nombre" type="text" class="mt-1 block w-full"
                                        placeholder="ej: John Smith" required v-model="form.nombre" />
                                    <InputError class="mt-2" :message="form.errors.nombre" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="telefono" value="Teléfono:" class="text-gray-300" />
                                    <TextInput id="telefono" type="tel" class="mt-1 block w-full" required
                                        v-model="form.telefono" />
                                    <InputError class="mt-2" :message="form.errors.telefono" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="comision" value="Comisión:" class="text-gray-300" />
                                    <TextInput id="comision" type="number" class="mt-1 block w-full" placeholder="0.00"
                                        v-model="form.comision" />
                                    <InputError class="mt-2" :message="form.errors.salario" />
                                </div>
                                <div class="mt-4 flex">
                                    <input type="checkbox" class="h-6 w-6 rounded-full shadow" name="tiene_efectivo"
                                        id="tiene_efectivo" v-model="form.tiene_efectivo" :true-value="1" :false-value="0">
                                    <InputLabel for="tiene_efectivo" class="flex flex-col px-2 text-gray-300 justify-center"
                                        value="Tiene efectivo?" />
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                        type="submit">Guardar</PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div class="bg-gray-400 sm:col-span-2 dark:bg-slate-700 border border-gray-800 p-4 rounded-md">
                            <h1 class="sm:col-span-3 font-bold text-2xl text-center text-gray-600 dark:text-gray-200">Resumen</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    mensajero: {
        type: Object,
        default: () => ({})
    }
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
</script>