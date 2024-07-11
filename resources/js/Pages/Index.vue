<template>
    <q-page-container>

            <div class="row justify-center">
                <div v-for="balanceTransaction of balanceTransactions" v-bind:key="balanceTransaction.id" class="col-5 q-ma-md">
                    <q-card v-bind:class="['text-white', balanceTransaction.type === 'credit' ? 'bg-secondary': 'bg-negative']" flat bordered >
                        <q-card-section>
                            <div class="text-h6">Описание: {{ balanceTransaction.description }}</div>
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <span>Тип операции:</span>
                            <span class="q-ml-md text-italic">{{ balanceTransaction.type }}</span>
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <span>Количество средств {{ balanceTransaction.type === 'credit' ? 'начислено' : 'списано' }}:</span>
                            <span class="q-ml-md text-italic">{{ balanceTransaction.amount }}</span>
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <span>Количество средств после операции:</span>
                            <span class="q-ml-md text-italic">{{ balanceTransaction.balance_after }}</span>
                        </q-card-section>
                    </q-card>
                </div>

            </div>

        <div v-if="!balanceTransactions?.length" class="fixed-center">Нет данных</div>
    </q-page-container>
</template>

<script setup>
import {useBalanceTransactionStore} from "../Stores/balanceTransaction";
import {computed, onBeforeUnmount, onMounted} from "vue";
import {useBalanceStore} from "../Stores/balance";

const balanceTransactionStore = useBalanceTransactionStore()
const balanceStore = useBalanceStore()

const balanceTransactions = computed(
    () => balanceTransactionStore.balanceTransactions
        .sort((a, b) => a.id > b.id ? 1 : -1).slice(0, 5)
)

onMounted(() => balanceTransactionStore.getBalanceTransactions())
onMounted(() => balanceStore.getBalance())

const interval = setInterval(() => balanceStore.getBalance(), 10000)

onBeforeUnmount(() => clearInterval(interval))

</script>

<style scoped>

</style>
