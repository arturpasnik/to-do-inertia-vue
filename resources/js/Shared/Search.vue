<template>


    <div v-if="showHideSearch" class="w-full flex flex-col absolute z-51 mt-16">
        <div class="bg-scrums-gradient-blue w-full lg:w-1/2 md:mx-auto animate-fade-in-down">

            <div class="flex flex-col mx-auto px-20 py-10 overflow-y-scroll">
                <template v-if="results && (results.cards.length > 0 || results.groups.length > 0)">
                    <Link v-for="c in results.cards" @click="closeSearch" :href="route('card.show',{'c':c.first_category.cat_id,'s':c.first_category.sub_id,'g':c.first_category.group_id, 'card':c.id})" class="flex flex-col p-4 border-b-white border-solid border-b-2">
                        <div class="w-full flex justify-between text-xl text-white hover:text-blue-light cursor-pointer">
                            <div>{{ c.name }}</div>
                            <div class="ml-3">CARD</div>
                        </div>
                    </Link>
                    <Link v-for="g in results.groups" @click="closeSearch" :href="g.url" class="flex flex-col p-4 border-b-white border-solid border-b-2">
                        <div class="w-full flex justify-between text-xl text-white hover:text-blue-light cursor-pointer ">
                            <div>{{ g.name }}</div>
                            <div class="ml-3">DECK</div>
                        </div>
                    </Link>

                    <div class="w-full flex justify-between text-xl text-white hover:text-blue-light cursor-pointer ">
                        <a @click="viewAllResults" class="mt-8 ml-4 text-white hover:text-blue-light">VIEW ALL RESULTS</a>
                    </div>



                </template>

                <template v-else-if="results && results.cards.length === 0 && results.groups.length === 0">
                    <p class="text-white text-center text-xl">No results</p>
                </template>

                <template v-else>
                    <p class="text-white text-center text-xl">Loading...</p>
                </template>


            </div>

        </div>


    </div>


</template>

<script setup>
import {Link, usePage, useForm} from '@inertiajs/inertia-vue3'
import {computed, inject, ref} from "vue";
import axios from "axios";


const clicks = ref(0);
const closeWhenClickedOutsideSearch = (event) => {
    clicks.value++;
    if (clicks.value > 0 && !event.target.closest('#mainPage')) {
        if (showHideSearch.value) {
            closeSearch();
            document.removeEventListener('click', closeWhenClickedOutsideSearch);
            clicks.value = 0;
        }
    }
}

const events = inject('emitter');

const showHideSearch = ref(false);
const results = ref(false);
const form = useForm({
    search: null
});

events.on('showSearch', (data) => {
    document.addEventListener('click', closeWhenClickedOutsideSearch);
    showHideSearch.value = true;
    form.search = data;
    searchForm();
});
events.on('hideSearch', (data) => {
    document.removeEventListener('click', closeWhenClickedOutsideSearch);
    showHideSearch.value = false;
    results.value = false;
    form.search = null;
});

const closeSearch = () => {
    document.removeEventListener('click', closeWhenClickedOutsideSearch);
    results.value = false;
    showHideSearch.value = false;
    form.search = null;
    events.emit('clearSearch');
}

const searchForm = () => {
    results.value = false;
    axios.post('/api/search', {search: form.search})
        .then((response) => {
            results.value = response.data;
        });
}

const viewAllResults = () => {
    form.post(route("search"));
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
