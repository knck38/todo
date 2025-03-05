<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head, Link, router } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
});

const form = useForm({
    task: '',
    status: '',
});

const submit = () => {
    form.post(route('task.store'), { 
        onSuccess: () => {
            form.reset();
        }
    });
};

const changeStatus = (task) => {
    task.status = !task.status;
    form.status = task.status;
    form.put(route('task.update', task.id));
}

const deleteTask = (id) => {
    if (confirm('本当に削除しますか？')) {
        router.delete(route('task.destroy', id));
    }
};

</script>
 
<template>
    <Head title="TODO管理アプリ" />
    
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-10">
        <h2 class="text-3xl font-mono italic text-center my-6">TODOリスト</h2>
        <form @submit.prevent="submit">
            <input 
            v-model="form.task"
            placeholder="何をする？" 
            class="block w-full bg-transparent border-4 border-[#3c3133] px-5 py-6 focus:border-[#e60012] focus:ring focus:ring-[#e60012] focus:ring-opacity-0 rounded-2xl placeholder-current focus:placeholder-red-300"
            type="text" name="task" />
            <InputError :message="form.errors.task" class="mt-2" />
            <div class="mt-4 text-center">
                <PrimaryButton>追加</PrimaryButton>
            </div>
        </form>

        <ul 
        v-if="tasks.length"
        class="mt-10 px-5 border-4 border-[#3c3133] rounded-2xl divide-y">
            <li 
            class="flex py-6 border-[#3c3133]" 
            :class="{'line-through': task.status}"
            v-for="task in tasks" :key="task.id">
                <div class="flex-none mr-2">
                    <!-- 完了アイコン -->
                    <button @click.prevent="changeStatus(task)" 
                    class="px-2 hover:text-[#e60012] transition duration-150 ease-in-out">
                        <i v-if="task.status === 1" class="fa-regular fa-square-check"></i>
                        <i v-else class="fa-regular fa-square"></i>
                    </button>
                </div>
                {{ task.task }}
                <div class="flex-none ml-auto">
                    <!-- 編集アイコン -->
                    <Link :href="route('task.edit', task.id)" 
                    class="px-2 hover:text-[#e60012] transition duration-150 ease-in-out">
                        <i class="fa-solid fa-pen"></i>
                    </Link>
                    <!-- 削除アイコン -->
                    <button @click.prevent="deleteTask(task.id)" 
                    class="px-2 hover:text-[#e60012] transition duration-150 ease-in-out">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>