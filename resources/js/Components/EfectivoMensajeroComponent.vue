<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:space-x-2">
            <TextInput id="cantidad" type="number" class="block" required v-model="form.cantidad"
                placeholder="Cantidad" />
            <input type="hidden" id="mensajero_id" v-model="form.mensajero_id">
            <input type="hidden" id="url" v-bind:value="getUrl">
            <select v-model="form.moneda_id" id="monedas"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option v-for="moneda in props.monedas" v-bind:value="moneda.id">{{
                    moneda.nombre
                }}</option>
            </select>
            <PrimaryButton class="mt-4 sm:mt-1">Guardar</PrimaryButton>
        </div>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import TextInput from './TextInput.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    monedas: {
        type: Object,
        default: () => ({})
    },
    mensajero: {
        type: Object,
        default: () => ({})

    }
})

const getUrl = window.location.pathname

const form = useForm({
    cantidad: '',
    moneda_id: '',
    mensajero_id: props.mensajero.id,
    url: '',
})

const submit = () => {
    // console.log(form)
    form.post(route('mensajero.efectivo'))
    form.reset()
}
</script>