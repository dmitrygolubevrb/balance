import { defineStore } from 'pinia'
import axios from "axios";

export const useBalanceTransactionStore = defineStore('balanceTransaction', {
    state: () => ({
        balanceTransactions: [],
    }),
    // getters: {
    //     isLoading: (state) => state.isLoading,
    // },
    actions: {
        getBalanceTransactions() {
            return axios.get('/balance-transactions').then(res => this.balanceTransactions = res.data)
        },
    },
})
