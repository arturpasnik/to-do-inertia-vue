<template>
    <div v-if="data.display" class="absolute z-50 w-full h-screen justify-center items-center bg-black/50" @click="hideFlash">
        <div class="flex w-full pt-28 justify-center">
            <div class="p-12 h-46 rounded-2xl text-white "  :class="{'bg-green-800': data.type === 'success', 'bg-red-800': data.type === 'error'} ">
                <p class="text-center font-bold text-xl tracking-wider">{{data.text}}</p>
            </div>
        </div>
    </div>
</template>



<script setup>
import {inject, reactive} from "vue";

const events = inject('emitter');
const data = reactive({display: false, type: 'success', text: ''});

events.on('flashSuccess', (text) => {
   data.display = true;
   data.text = text;
});

events.on('flashError', (text) => {
    data.display = true;
    data.type = 'error';
    data.text = text;
});

function hideFlash(){
    data.display = false;
    data.text = null;
}

</script>

<style scoped>

</style>
