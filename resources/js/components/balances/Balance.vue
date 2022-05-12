<template>
    <div class="container mx-auto">
        <div class="my-4">
            <h2 class="text-center text-4xl">Balances</h2>
        </div>
        <div class="overflow-x-auto lg:overflow-x-hidden w-full shadow">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th class="p-0 flex justify-end">
                        <a @click.prevent="openCreateModal"
                           class="bg-primary btn py-4 px-3 text-center text-primary-content rounded-none rounded-tr-lg">Add
                            Balance</a>
                    </th>
                </tr>
                </thead>
                <tbody v-if="balances.length > 0">
                <!-- row 1 -->
                <tr v-for="(balance, idx) in balances" :key="idx">
                    <td>{{ ((pagination.currentPage - 1) * pagination.limit) + (idx + 1) }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold">{{ balance.title }}</div>
                                <div class="text-sm opacity-50">{{ balance.details?.slice(0, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ balance.formatted_amount }}
                        <br>
                        <span class="badge badge-ghost badge-sm">{{ balance.method }}</span>
                    </td>
                    <td>{{ balance.created }}</td>
                    <th class="space-x-1">
                        <a @click.prevent="(event) => balanceDetails(event, balance.id)"
                           class="btn-modal btn btn-outline btn-info"
                        >details</a>
                        <a @click.prevent="(event) => editBalance(event, balance.id)"
                           class="btn btn-outline btn-warning"
                        >edit</a>
                        <a @click.prevent="(event) => deleteBalance(event, balance.id)"
                           class="btn btn-outline btn-error">delete</a>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-middle py-5" v-if="balances.length <= 0">
            <progress class="progress w-56"></progress>
        </div>

        <div class="flex justify-center py-5">
            <Paginator :data-function="getBalances" :next-page="nextPage" :prev-page="prevPage"
                       :paginator="pagination"/>
        </div>
    </div>

    <!-- Modals -->
    <Details/>
    <Create/>
    <Edit/>
    <Delete />

</template>

<script>
import useBalance from "../../composables/balance";
import useMethod from "../../composables/method";
import useModal from "../../composables/modal";
import {onMounted} from "vue";
import Create from "./Create";
import Details from "./Details";
import Edit from "./Edit";
import Paginator from "../Paginator";
import Delete from "./Delete";

export default {
    name: "Balance",
    components: {Delete, Paginator, Details, Create, Edit},
    setup() {
        const {
            balances,
            balance,
            pagination,
            getBalances,
            getBalance,
            nextPage,
            prevPage
        } = useBalance();
        const {getMethods} = useMethod();
        const {
            modal,
            closeModal,
            openDeleteModal,
            openCreateModal,
            openDetailsModal,
            openEditModal,
            startLoading,
            stopLoading
        } = useModal();

        onMounted(() => {
            getBalances(1);
            getMethods();
        });

        const balanceDetails = async (event, id) => {
            startLoading(event);
            await getBalance(id);
            openDetailsModal();
            stopLoading(event);
        };

        const editBalance = async (event, id) => {
            startLoading(event);
            await getBalance(id);
            openEditModal();
            stopLoading(event);
        };

        const deleteBalance = (event, id) => {
            startLoading(event);
            balance.value.id = id;
            console.log(balance);
            openDeleteModal();
            stopLoading(event);
        };

        return {
            balances,
            nextPage,
            prevPage,
            modal,
            closeModal,
            openDeleteModal,
            openCreateModal,
            openDetailsModal,
            openEditModal,
            balanceDetails,
            getBalances,
            pagination,
            editBalance,
            deleteBalance,
        };
    }
}
</script>

<style scoped>

</style>
