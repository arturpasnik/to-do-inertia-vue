<template>
    <transition name="modal-animation" v-if="showModal">
        <div class="modal">
            <transition name="modal-animation-inner">
                <div class="modal-inner">
                    <div class="modal-content bg-amber-100">
                        <div class="flex flex-col font-bold text-xl p-24">
                            <div class=" flex justify-center pb-4">
                                <p class="justify-center">{{ data.msg }}</p>
                            </div>
                            <div class=" flex flex-row py-4 justify-between">
                                <button type="button" @click.prevent="closeModalPopUp()" class=" px-2 text-white bg-blue hover:bg-purple-800 shadow-md hover:border-purple-800 font-bold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300">Close</button>

                                <button type="button" @click.prevent="confirmed()" class="px-2 my-auto text-white bg-red-700 hover:bg-red-800 shadow-md hover:border-purple-800 font-bold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-cente transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Confirm</button>

                            </div>
                        </div>
                    </div>

                </div>
            </transition>
        </div>
    </transition>
</template>

<script setup>
import {ref, reactive, inject} from "vue";
import axios from "axios";

const events = inject('emitter');

const showModal = ref(false);

const closeModalPopUp = () => {
    showModal.value = false;
}

const data = reactive({msg: '', callback: '', model: {}});

events.on('showConfirmModal', (event) => {
    console.log('ok');
    showModal.value = true;
    data.msg = event.msg;
    data.callback = event.callback;
    data.model = event.model;

});

const confirmed = () => {
    events.emit(data.callback, data.model);
    showModal.value = false;
}


</script>

<style lang="scss" scoped>
.modal-animation-enter-active,
.modal-animation-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-enter-from,
.modal-animation-leave-to {
    opacity: 0;
}

.modal-animation-inner-enter-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}

.modal-animation-inner-leave-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-inner-enter-from {
    opacity: 0;
    transform: scale(0.8);
}

.modal-animation-inner-leave-to {
    transform: scale(0.8);
}

.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(255, 255, 255, 0.7);

    .modal-inner {
        position: relative;
        max-width: 640px;
        width: 50%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        background-color: #fff;
        padding: 64px 16px;

    }
}
</style>
