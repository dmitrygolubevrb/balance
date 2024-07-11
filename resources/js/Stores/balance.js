import { defineStore } from 'pinia'
import axios from "axios";

export const useBalanceStore = defineStore('balance', {
    state: () => ({
        currentBalance: null,
    }),
    // getters: {
    //     isLoading: (state) => state.isLoading,
    // },
    actions: {
        getBalance() {
            return axios.get('/balance').then(res => this.currentBalance = res.data.balance)
        },
    },
})
