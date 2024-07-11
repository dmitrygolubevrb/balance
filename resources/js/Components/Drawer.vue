<template>
    <div class="q-ml-md">
        <q-btn flat @click="drawerIsVisible = !drawerIsVisible" round dense icon="menu" />
        <q-drawer
            :model-value="drawerIsVisible"
            side="right"
            :breakpoint="500"
            bordered
            :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'"
            overlay
        >
            <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" style="height: 150px">
                <div class="absolute-bottom bg-transparent">
                    <q-avatar color="primary" size="70px" class="q-mb-sm">
                        {{ userInfo.full_name?.split(/\s+/).map((word, index) => index <= 3 ? word.substring(0, 1).toUpperCase() : false).join('') }}
                    </q-avatar>
                    <div class="text-weight-bold">{{ userInfo.full_name }}</div>
                    <div>{{ userInfo.login }}</div>
                </div>
            </q-img>
            <q-list class="text-secondary" style="margin-top: 150px" padding>
                <q-item @click="logout" class="fixed-bottom text-negative" clickable v-ripple>
                    <q-item-section avatar>
                        <q-icon name="logout" />
                    </q-item-section>

                    <q-item-section>
                        Выйти
                    </q-item-section>
                </q-item>
            </q-list>
        </q-drawer>
    </div>

</template>

<script setup>
import {ref} from "vue";
import {useAuthStore} from "../Stores/auth";
import {storeToRefs} from "pinia";
import {useRouter} from "vue-router";

const router = useRouter()
const authStore = useAuthStore()

const { userInfo } = storeToRefs(authStore)
const drawerIsVisible = ref(false)

const logout = () => authStore.logout().then(() => router.push({name: 'login'}))

</script>

<style scoped>

</style>
