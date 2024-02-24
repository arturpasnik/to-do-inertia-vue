<template>
    <div class="sticky top-0 w-screen bg-scrums-gradient-blue z-50 flex px-10 h-16">
        <div class="w-1/2 md:w-1/3 flex items-center">
            <Link :href="route('home')">
                <img src="/img/SR_Gainline-notag-whiteout.png" alt="" id="logo" class="w-3/4 lg:w-1/2"/>
            </Link>
        </div>
        <div class="hidden md:flex md:w-1/3 items-center">
            <div @keyup.enter="submitSearchForm()" class="w-full">
                <div class="flex justify-center items-center text-black bg-inherit focus:border-none active:border-none group w-full">
                    <input ref="searchInput" v-model="form.search" class="w-full p-2 bg-inherit text-black focus:outline-none focus:border-scrums-gradient-lightblue search_bar" type="text" placeholder="Search..">
                    <button type="submit" class=" w-auto flex justify-end items-center p-2 hover:text-white" @click.prevent="submitSearchForm()">
                        <svg class="w-5 h-5 text-white hover:text-scrums-gradient-lightblue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
        <div class="w-1/2 md:w-1/3 flex justify-end items-center">
            <Link :href="route('favorites')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mr-8 fill-white text-white hover:fill-scrums-gradient-lightblue hover:text-scrums-gradient-lightblue cursor-pointer ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                </svg>
            </Link>

            <svg @click="hideShowMenuToggle()" viewBox="0 0 100 80" width="40" height="40" fill="white" class="fill-white hover:fill-scrums-gradient-lightblue cursor-pointer">
                <rect width="100" height="15"></rect>
                <rect y="30" width="100" height="15"></rect>
                <rect y="60" width="100" height="15"></rect>
            </svg>

        </div>
    </div>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/inertia-vue3'
import {inject, watch, ref} from "vue";


const events = inject('emitter');

const searchInput = ref();
const updateTopSearch = () => {
    events.emit('topSearchUpdated', form.search);
}

const form = useForm({
    search: ''
});

events.on('clearSearch', () => {
    form.search = null;
});

watch(
    () => form.search,
    (search) => {

        const timeoutId = window.setTimeout(() => {
        }, 0);
        for (let id = timeoutId; id >= 0; id -= 1) {
            window.clearTimeout(id);
        }

        setTimeout(() => {
            if (search.length > 2) {
                events.emit('showSearch', form.search);
            } else {
                events.emit('hideSearch');
            }
        }, 500);


    }
)

const submitSearchForm = () => {
    form.post(route("search"));
}

const hideShowMenuToggle = () => {
    events.emit('hideShowMenu');
}


</script>
<style scoped>

.search_bar {
    background-color: transparent;
    border: 0;
    border-bottom: 1px solid #fff;
    border-radius: 0;
    padding: 4px;
    color: white;
}

.search_bar:active {
    outline: none;
    outline: 0;
    border: 0;
    outline: transparent !important;
    color: white;
}

.search_bar:focus {
    box-shadow: none !important;
}

.search_bar::placeholder {
    color: white;
}

</style>
