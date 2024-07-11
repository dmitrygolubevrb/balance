<template>
    <q-page-container v-if="balanceTransactions">
        <div class="q-pa-md">
            <q-table
                flat bordered
                grid
                title="Все Транзакции"
                :rows="balanceTransactions"
                :columns="columns"
                row-key="id"
                :filter="filter"
                hide-header
            >
                <template v-slot:top-right>
                    <q-input borderless dense debounce="300" v-model="filter" placeholder="Поиск по описанию">
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </template>
            </q-table>
        </div>
    </q-page-container>
</template>

<script setup>
import {computed, onMounted} from "vue";
import {useBalanceTransactionStore} from "../Stores/balanceTransaction";
import {ref} from "vue";

const balanceTransactionStore = useBalanceTransactionStore()

const balanceTransactions = computed(() => balanceTransactionStore.balanceTransactions)

const filter = ref('')
const columns = [
    {
        name: 'description',
        label: 'Описание',
        align: 'left',
        field: 'description',
        format: val => `${val}`,
        sortable: true
    },
    { name: 'amount', align: 'center', label: 'Количество средств', field: 'amount', sortable: true },
    { name: 'balance_after', label: 'Баланс после операции', field: 'balance_after', sortable: true },
    { name: 'type', label: 'Тип транзакции', field: 'type' }
]

</script>

<style scoped>

</style>
