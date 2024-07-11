import { defineStore } from 'pinia'

export const useMainStore = defineStore('main', {
    state: () => ({
        isLoading: false,
    }),
    // getters: {
    //     isLoading: (state) => state.isLoading,
    // },
    actions: {
        toggleIsLoading() {this.isLoading = !this.isLoading}
    },
})
