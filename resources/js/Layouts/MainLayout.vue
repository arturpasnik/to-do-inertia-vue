<template>
    <Flash/>
    <ModalPopUp/>
    <div class="w-3/4 mx-auto">
        <div class="w-full flex py-4">
            <img src="/img/logo.png">
        </div>
        <slot>Default</slot>
        <Footer/>
    </div>


</template>

<script setup>


import Footer from "@/Components/Footer.vue";
import Flash from "@/Shared/Flash.vue";
import ModalPopUp from "@/Shared/ModalPopUp.vue";
</script>

<style scoped>

</style>
