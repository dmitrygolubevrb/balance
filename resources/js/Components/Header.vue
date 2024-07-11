<template>
    <q-header elevated :class="[$q.dark.isActive ? 'bg-black' : 'bg-secondary', 'q-py-sm']">
        <q-toolbar>
            <q-toolbar-title>{{ metaTitle || title }}</q-toolbar-title>
            <q-btn
                class="q-mr-md"
                :to="{name: route.name === 'history' ? 'index' : 'history'}"
                :label="route.name === 'history' ? 'На главную' : 'История'"
                color="secondary"
                no-caps
            />
            <q-toggle
                v-model="darkMode"
                checked-icon="dark_mode"
                unchecked-icon="light_mode"
                color="blue-grey-8"
                :label="darkMode ? 'Темный режим' : 'Светлый режим'"
            />
            <slot name="right"/>
        </q-toolbar>
    </q-header>
</template>

<script setup>
import {useQuasar} from 'quasar'
import {useRoute} from 'vue-router'
import {computed, ref, toRefs, watch} from "vue";
import {useMainStore} from "../Stores/main";

const darkMode = ref(false)
const quasar = useQuasar()
const route = useRoute()
defineProps({
    title: [String, null]
})

const metaTitle = computed(() => route.meta.title)

watch(darkMode, value => quasar.dark.set(value))

</script>

<style scoped>

</style>
