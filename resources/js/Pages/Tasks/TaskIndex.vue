<template>
  <div class="flex flex-col md:flex-row">
    <div class="w-full md:w-1/4 flex flex-col space-y-4 p-3">
      <div class="flex flex-col">
        <input type="text" name="name" v-model="newTaskForm.name" placeholder="Insert task name" class="w-full">
        <div v-if="newTaskForm.errors.name" class="text-red-700">{{ newTaskForm.errors.name }}</div>
      </div>
      <div class="flex">
        <button @click.prevent="handleCreateTask" class="btn bg-blue-700 text-center text-white p-3 w-full ">Add</button>
      </div>


    </div>
    <div class="w-full md:w-3/4">
      <div class="flex bg-white p-4">
        <table class="border-collapse table-auto w-full text-sm">
          <thead>
          <tr>
            <th class="w-16 border-b font-bold p-4 pl-8 pt-0 pb-3 text-blue-900 text-left">#</th>
            <th class="border-b font-medium p-4 pt-0 pb-3 text-blue-900 text-left">Task</th>
          </tr>
          </thead>
          <tbody class="bg-white">
          <tr v-for="task in tasks">
            <td class="border-b border-slate-100 p-4 pl-8 text-slate-500 font-bold">{{ task.id }}</td>
            <td class="border-b border-slate-100 p-4 text-slate-500 flex flex-col md:flex-row justify-between">
              <div :class="{'line-through' : task.status === 2 }">{{ task.name }}</div>
              <div v-if="task.status === 1" class="flex space-x-2">
                <button @click="handleMarkCompletedTask(task.id)" class="w-6 h-6 bg-green-600 hover:bg-green-800">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                  </svg>
                </button>

                <button @click="confirmDeleteTask(task.id)" class="w-6 h-6 bg-red-600 hover:bg-red-800">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>


<script setup>
import {watch, inject} from 'vue';
import {useForm, usePage} from "@inertiajs/inertia-vue3";

const events = inject('emitter');
const page = usePage();

const props = defineProps({
  tasks: Array
});

const newTaskForm = useForm({
  name: '',
});

const taskForm = useForm({
  id: '',
});

const handleCreateTask = () => {
  if (newTaskForm.name === null || newTaskForm.name.trim() === "") {
    newTaskForm.errors.name = 'The name field is required.';
    return;
  }
  newTaskForm.post(route("task.store"), {
    onSuccess: () => {
      events.emit('flashSuccess', 'Task created');
      newTaskForm.reset();
      setTimeout(function(){
        newTaskForm.clearErrors()
      }, 10);
    }
  });
}

const handleMarkCompletedTask = (id) => {
  taskForm.id = id;
  taskForm.put(route("task.update"), {
    onSuccess: () => {
      events.emit('flashSuccess', 'Task updated');
      taskForm.reset();
    }
  });
}

const confirmDeleteTask = (taskId) => {
  events.emit('showConfirmModal', {msg: 'Confirm Delete Task', callback: 'confirmedDeleteTask', model: taskId});
}
events.on('confirmedDeleteTask', (id) => {
  taskForm.id = id;
  taskForm.delete(route("task.destroy"), {
    onSuccess: () => {
      events.emit('flashSuccess', 'Task deleted');
      taskForm.reset();
    }
  });
});

watch(() => newTaskForm.name, async (newTaskName, oldTaskName) => {
  if (newTaskName === null || newTaskName.trim() === "") {
    newTaskForm.setError('name', 'The name field is required.');
  } else {
    newTaskForm.clearErrors();
  }
})

</script>

<style scoped>

</style>
