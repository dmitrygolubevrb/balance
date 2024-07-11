<template>
    <q-layout view="hHh Lpr fFf" class="shadow-2 rounded-borders">
        <Header>
            <template v-slot:right>
                <Drawer/>
            </template>
        </Header>
        <q-page-container >
            <q-page style="padding-top: 5%" class="q-pa-md">
                <RouterView/>
                <q-page-sticky position="top" expand>
                    <Toolbar/>
                </q-page-sticky>
            </q-page>
            <q-page-scroller position="bottom">
                <q-btn fab icon="keyboard_arrow_up" color="red" />
            </q-page-scroller>
        </q-page-container>
    </q-layout>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import Toolbar from "@/Components/Toolbar.vue";
import Drawer from "@/Components/Drawer.vue";


</script>

<style scoped>

</style>
