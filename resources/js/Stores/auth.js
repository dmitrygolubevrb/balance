import { defineStore } from 'pinia'
import axios from "axios";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authCredentials: {
            login: null,
            password: null,
            remember: false
        },
        registrationFields: {
            login: null,
            full_name: null,
            password: null,
            password_confirmation: null
        },
        userInfo: {
            full_name: null,
            login: null
        }
    }),
    getters: {
        isAuth: (state) => Boolean(state.userInfo.full_name || state.userInfo.login),
    },
    actions: {
        login() {
            return axios.get('/sanctum/csrf-cookie').then(() => axios.post('/login', this.authCredentials))
        },
        registration() {
            return axios.post('/registration', this.registrationFields)
        },
        logout() {
            return axios.post('/logout')
        },
        clearRegistrationFields() {
            this.registrationFields = {
                login: null,
                full_name: null,
                password: null,
                password_confirmation: null
            }
        },
        clearAuthCredentials() {
            this.authCredentials = {
                login: null,
                password: null,
                remember: false
            }
        },
        getUserInfo() {
            return axios.get('/user').then(res => this.userInfo = res.data)
        }
    },
})
