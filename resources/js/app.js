import './bootstrap';

import {createApp} from 'vue';
import {Quasar, Notify, Cookies, useQuasar} from 'quasar'
import quasarLang from 'quasar/lang/ru'
import '@quasar/extras/material-icons/material-icons.css'
import 'quasar/src/css/index.sass'
import store from './Stores/index.js'
import router from './router.js'
import App from './App.vue'
import {useAuthStore} from "./Stores/auth";
import {useMainStore} from "./Stores/main";
import axios from "axios";


const pinia = store()

createApp(App)
    .use(Quasar, {
        plugins: {Notify, Cookies},
        config: {
            notify: {position: 'bottom-right'}
        },
        lang: quasarLang,
    })
    .use(pinia)
    .use(router)
    .mount('#app')

const authStore = useAuthStore()
const mainStore = useMainStore()


router.beforeEach((to, from, next) => {
    if (!authStore.isAuth && to.name !== 'login' && to.name !== 'registration') {
        return authStore.getUserInfo().then(() => next()).catch(() => next({name: 'login'}))
    }
    else next()

})

axios.interceptors.request.use(
    config => {
        mainStore.toggleIsLoading()
        return config
    },
    error => {
        mainStore.toggleIsLoading()
        return Promise.reject(error)
    })
axios.interceptors.response.use(
    config => {
        mainStore.toggleIsLoading()
        return config
    },
    error => {
        mainStore.toggleIsLoading()
        if (error.response.status === 401 || error.response.status === 419) router.push({name: 'login'})
        return Promise.reject(error)
    })

