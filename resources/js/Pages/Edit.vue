<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    task: Object,
});
 
const form = useForm({
    task: props.task.task,
});

const submit = () => {
    form.put(route('task.update', props.task.id));
};
</script>

<template>
    <Head title="編集ページ" />

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-10">
        <h2 class="text-3xl font-mono italic text-center my-6">TODOを編集</h2>
        <form @submit.prevent="submit">
            <input 
            v-model="form.task"
            class="block w-full bg-transparent border-4 border-[#3c3133] px-5 py-6 focus:border-[#e60012] focus:ring focus:ring-[#e60012] focus:ring-opacity-0 rounded-2xl placeholder-current focus:placeholder-red-300" 
            type="text" />
            <InputError :message="form.errors.task" class="mt-2" />
            <div class="mt-4 text-center">
                <PrimaryButton>更新</PrimaryButton>
            </div>
        </form>
    </div>
</template>