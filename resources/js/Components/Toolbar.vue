<template>

    <q-toolbar :class="[$q.dark.isActive ? 'bg-black' : 'bg-secondary', 'text-white', 'q-py-md']">
        <span class="text-italic text-h5">
        <q-icon class="text-h4 q-mr-md" name="account_circle"/>
            {{ userInfo.full_name }}
        </span>
        <q-space/>
        <span v-show="currentBalance" class="q-mr-xl text-italic text-h5">
            <q-icon class="text-h4" name="attach_money"/>
            Текущий баланс: {{ currentBalance }}
        </span>
    </q-toolbar>

</template>

<script setup>
import {useBalanceStore} from "../Stores/balance";
import {useAuthStore} from "../Stores/auth";
import {computed, onBeforeUnmount} from "vue";

const balanceStore = useBalanceStore()
const authStore = useAuthStore()
const { userInfo } = authStore

const currentBalance = computed(() => balanceStore.currentBalance)

</script>

<style scoped>

</style>
