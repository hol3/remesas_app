<template>
    <Head title="Editar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ item.nombre_cliente }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6 shadow-sm sm:rounded-lg">                    
                    <form @submit.prevent="submit" class="px-8">
                        <div class="mt-4">
                            <InputLabel for="codigo" value="Codigo:" />
                            <TextInput id="codigo" type="text" class="mt-1 block w-full" v-model="form.codigo" required
                                autofocus onkeyup="this.value = this.value.toUpperCase();" />
                            <InputError class="mt-2" :message="form.errors.codigo" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="nombre_cliente" value="Nombre del cliente:" />
                            <TextInput id="nombre_cliente" type="text" class="mt-1 block w-full"
                                v-model="form.nombre_cliente" required autocomplete="nombre_cliente" />
                            <InputError class="mt-2" :message="form.errors.nombre_cliente" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="telefono" value="Telefono:" />
                            <TextInput id="telefono" type="tel" class="mt-1 block w-full" v-model="form.telefono" />
                            <InputError class="mt-2" :message="form.errors.direccion" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="cantidad" value="Cantidad:" />
                            <TextInput id="cantidad" type="number" class="mt-1 block w-full" v-model="form.cantidad" />
                            <InputError class="mt-2" :message="form.errors.cantidad" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="monedas" value="Tipo de moneda" />
                            <select v-model="form.moneda_id" id="monedas"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option v-for="moneda in monedas" v-bind:value="moneda.id">{{
                                    moneda.nombre
                                }}</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="comision" value="Comision:" />
                            <TextInput id="comision" type="number" class="mt-1 block w-full" v-model="form.comision"
                                required />
                            <InputError class="mt-2" :message="form.errors.comision" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="municipios" value="Municipio" />
                            <select v-model="form.municipio_id" id="municipios" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value=""></option>
                                <option v-for="municipio in provincias[0].municipio" v-bind:value="municipio.id">
                                    {{
                                        municipio.nombre
                                    }}</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="direccion" value="Direccion:" />
                            <TextInput id="direccion" type="text" class="mt-1 block w-full" v-model="form.direccion" />
                            <InputError class="mt-2" :message="form.errors.direccion" />
                        </div>
                        <div>
                            <InputLabel for="mensajero" value="Mensajero:" />
                            <select v-model="form.mensajero_id" id="mensajero"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">Seleccione un mensajero</option>
                                <option v-for="mensajero in mensajeros" v-bind:value="mensajero.id">{{
                                    mensajero.nombre
                                }}</option>
                            </select>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Guardar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';

const props = defineProps({
    item: {
        type: Object,
        default: ({})
    },
    provincias: null,
    monedas: null,
    mensajeros: null,
})

const form = useForm({
    id: props.item.id,
    codigo: props.item.codigo,
    nombre_cliente: props.item.nombre_cliente,
    telefono: props.item.telefono,
    direccion: props.item.direccion,
    municipio_id: props.item.municipio_id,
    cantidad: props.item.cantidad,
    moneda_id: props.item.moneda_id,
    comision: props.item.comision,
    mensajero_id: props.item.mensajero_id,
})

const submit = () => {
    // console.log('Acabo de envier el formulario!!')    
    // console.log(form)
    form.put(route('remesas.update', props.item.id))
    // form.reset()
    // close()
}

</script>