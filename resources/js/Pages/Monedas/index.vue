<template>
    <Head title="Monedas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Monedas
            </h2>            
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex w-full justify-end">
                            <form @submit.prevent="submit" class="inline-flex">
                                <TextInput id="nombre" type="text" placeholder="ej: USD" class="block" v-model="form.nombre"/>
                                <PrimaryButton class="ml-2">Nueva moneda</PrimaryButton>
                            </form>
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 my-4 border">
                            <thead class="text-gray-700 text-sm p-10 text-center shadow-sm uppercase bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Simbolo</th>
                                    <th>Fecha</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="coin in props.coins" class="border-b">
                                    <td class="px-6 py-3 text-center">{{ coin.id }}</td>
                                    <td class="px-6 py-3 text-center">{{ coin.nombre }}</td>
                                    <td class="px-6 py-3 text-center">{{ coin.created_at }}</td>
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
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    coins: {
        type: Object,
        default: ({})
    }
})

const form = useForm({
    nombre: ''
})

const submit = () => {
    form.post(route('moneda.store'))
    form.reset()
}


</script>