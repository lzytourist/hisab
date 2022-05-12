<template>
    <div class="container mx-auto">
        <div class="my-4">
            <h2 class="text-center text-4xl">Expenses</h2>
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
                            Expense</a>
                    </th>
                </tr>
                </thead>
                <tbody v-if="expenses.length > 0">
                <!-- row 1 -->
                <tr v-for="(expense, idx) in expenses" :key="idx">
                    <td>{{ ((pagination.currentPage - 1) * pagination.limit) + (idx + 1) }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold">{{ expense.title }}</div>
                                <div class="text-sm opacity-50">{{ expense.details?.slice(0, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ expense.formatted_amount }}
                        <br>
                        <span class="badge badge-ghost badge-sm">{{ expense.method }}</span>
                    </td>
                    <td>{{ expense.created }}</td>
                    <th class="space-x-1">
                        <a @click.prevent="(event) => expenseDetails(event, expense.id)"
                           class="btn-modal btn btn-outline btn-info"
                        >details</a>
                        <a @click.prevent="(event) => editExpense(event, expense.id)"
                           class="btn btn-outline btn-warning"
                        >edit</a>
                        <a @click.prevent="(event) => deleteExpense(event, expense.id)"
                           class="btn btn-outline btn-error">delete</a>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-middle py-5" v-if="expenses.length <= 0">
            <progress class="progress w-56"></progress>
        </div>

        <div class="flex justify-center py-5">
            <Paginator :data-function="getExpenses" :next-page="nextPage" :prev-page="prevPage"
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
import useExpense from "../../composables/expense";
import useMethod from "../../composables/method";
import useModal from "../../composables/modal";
import {onMounted} from "vue";
import Create from "./Create";
import Details from "./Details";
import Edit from "./Edit";
import Paginator from "../Paginator";
import Delete from "./Delete";

export default {
    name: "Expense",
    components: {Delete, Paginator, Details, Create, Edit},
    setup() {
        const {
            expenses,
            expense,
            pagination,
            getExpenses,
            getExpense,
            nextPage,
            prevPage
        } = useExpense();
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
            getExpenses(1);
            getMethods();
        });

        const expenseDetails = async (event, id) => {
            startLoading(event);
            await getExpense(id);
            openDetailsModal();
            stopLoading(event);
        };

        const editExpense = async (event, id) => {
            startLoading(event);
            await getExpense(id);
            openEditModal();
            stopLoading(event);
        };

        const deleteExpense = (event, id) => {
            startLoading(event);
            expense.value.id = id;
            openDeleteModal();
            stopLoading(event);
        };

        return {
            expenses,
            modal,
            pagination,
            nextPage,
            prevPage,
            closeModal,
            openDeleteModal,
            openCreateModal,
            openDetailsModal,
            openEditModal,
            expenseDetails,
            getExpenses,
            editExpense,
            deleteExpense,
        };
    }
}
</script>

<style scoped>

</style>
