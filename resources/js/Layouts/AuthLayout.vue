<template>
    <q-layout view="hHh Lpr fFf" class="shadow-2 rounded-borders">
        <Header></Header>
        <q-page-container>
            <RouterView/>
        </q-page-container>
    </q-layout>
</template>

<script setup>
import Header from "@/Components/Header.vue"
</script>

<style scoped>

</style>
