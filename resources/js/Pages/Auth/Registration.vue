<template>
    <q-page-container>
        <div class="row">
            <div class="col-5 fixed-center">
                <q-form @submit="registration" class="q-gutter-sm">

                    <q-input
                        v-model="registrationFields.full_name"
                        :rules="[val => val && !!val.length || 'ФИО обязательно для заполнения']"
                        label="ФИО"
                        type="text"
                        no-error-icon
                        rounded
                        outlined
                    >
                        <template v-slot:prepend>
                            <q-icon name="person_outline"/>
                        </template>
                    </q-input>

                    <q-input
                        v-model="registrationFields.login"
                        :rules="[
                            val => val && !!val.length || 'Логин обязателен для заполнения'
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
                        v-model="registrationFields.password"
                        :rules="[
                            val => val && !!val.length || 'Пароль обязателен для заполнения',
                            val => !registrationFields.password_confirmation ||
                            val === registrationFields.password_confirmation || 'Пароли должны совпадать'
                        ]"
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

                    <q-input
                        v-model="registrationFields.password_confirmation"
                        :rules="[
                            val => val && !!val.length || 'Подтверждение пароля обязательно для заполнения',
                            val => val === registrationFields.password || 'Пароли должны совпадать'
                        ]"
                        label="Подтверждение пароля"
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

                    <div class="text-center">
                        <div class="q-mb-md">
                            <router-link class="text-info" :to="{name: 'login'}">Войти</router-link>
                        </div>
                        <q-btn color="primary" type="submit" :loading="isLoading" label="Зарегестрироваться" rounded>
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
import Header from '@/Components/Header.vue'
import {useAuthStore} from "@/Stores/auth";
import {useMainStore} from "@/Stores/main";
import {storeToRefs} from 'pinia'
import {onBeforeUnmount, ref} from 'vue'
import {useRouter} from 'vue-router'
import {patterns, useQuasar} from 'quasar'

const quasar = useQuasar()
const router = useRouter()
const authStore = useAuthStore()
const mainStore = useMainStore()

const {registrationFields} = storeToRefs(authStore)
const {isLoading} = storeToRefs(mainStore)

const isShowPassword = ref(true)
const {testPattern} = patterns

const registration = () => {
    authStore.registration()
        .then(() => quasar.notify({
            type: 'positive',
            message: `Пользователь ${registrationFields.value.login} успешно зарегестрирован`
        }))
        .then(() => router.push({name: 'login'}))
        .catch(error => quasar.notify({
            type: 'negative',
            message: error.response.data.message
        }))
}

onBeforeUnmount(() => authStore.clearRegistrationFields())

</script>

<style scoped>

</style>
