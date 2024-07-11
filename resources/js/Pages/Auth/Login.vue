<template>
    <q-page-container>
        <div class="row">
            <div class="col-5 fixed-center">
                <q-form @submit="auth" class="q-gutter-sm">
                    <q-input
                        v-model="authCredentials.login"
                        :rules="[
                            val => val && !!val.length || 'логин обязателен для заполнения'
                        ]"
                        label="Логин"
                        type="text"
                        no-error-icon
                        rounded
                        outlined
                    >
                        <template v-slot:prepend>
                            <q-icon name="alternate_email"/>
                        </template>
                    </q-input>

                    <q-input
                        v-model="authCredentials.password"
                        :rules="[val => val && !!val.length || 'Пароль обязателен для заполнения']"
                        label="Пароль"
                        :type="isShowPassword ? 'password' : 'text'"
                        no-error-icon
                        rounded
                        outlined
                    >
                        <template v-slot:prepend>
                            <q-icon name="key"/>
                        </template>
                        <template v-slot:append>
                            <q-icon
                                :name="isShowPassword ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isShowPassword = !isShowPassword"
                            />
                        </template>
                    </q-input>

                    <div class="text-left">
                        <q-checkbox keep-color v-model="authCredentials.remember" label="Запомнить меня" color="primary" />
                    </div>
                    <div class="text-center">
                        <div class="q-mb-md">
                            <router-link class="text-info" :to="{name: 'registration'}">Регистрация</router-link>
                        </div>
                        <q-btn color="primary" type="submit" :loading="isLoading" label="Войти" rounded>
                            <template v-slot:loading>
                                <q-spinner-pie/>
                            </template>
                        </q-btn>
                    </div>
                </q-form>
            </div>
        </div>
    </q-page-container>
</template>

<script setup>
import { useAuthStore } from "@/Stores/auth";
import {useMainStore} from "@/Stores/main";
import { storeToRefs } from 'pinia'
import {onBeforeUnmount, ref} from 'vue'
import {patterns, useQuasar} from 'quasar'
import {useRouter} from "vue-router";

const router = useRouter()
const authStore = useAuthStore()
const mainStore = useMainStore()

const quasar = useQuasar()
const { authCredentials } = storeToRefs(authStore)
const { isLoading } = storeToRefs(mainStore)

const isShowPassword = ref(true)
const auth = () => {
    authStore.login().then(() => router.push({name: 'index'})).catch(error => quasar.notify({type: 'negative', message: error.response.data.message}))
}

onBeforeUnmount(() => authStore.clearAuthCredentials())
</script>

<style scoped>

</style>
