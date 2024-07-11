import {createWebHistory, createRouter} from 'vue-router'


const routes = [
    {
        path: '/login',
        component: () => import('@/Layouts/AuthLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('./Pages/Auth/Login.vue'),
                name: 'login',
            }
        ],
        meta: {title: 'Аутентификация'}
    },
    {
        path: '/registration',
        component: () => import('@/Layouts/AuthLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('./Pages/Auth/Registration.vue'),
                name: 'registration',
            }
        ],
        meta: {title: 'Регистрация'}
    },
    {
        path: '/',
        component: () => import('@/Layouts/MainLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('@/Pages/Index.vue'),
                name: 'index',
            }
        ],
        meta: {title: 'Главная страница'}
    },
    {
        path: '/history',
        component: () => import('@/Layouts/MainLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('@/Pages/TransactionHistory.vue'),
                name: 'history',
            }
        ],
        meta: {title: 'История транзакций'}
    },
    {
        path: '/:catchAll(.*)*',
        component: () => import('./Pages/ErrorNotFound.vue'),
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
