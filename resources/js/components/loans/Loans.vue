<template>
    <div class="container mx-auto">
        <div class="my-4">
            <h2 class="text-center text-4xl">Loans</h2>
        </div>
        <div class="overflow-x-auto lg:overflow-x-hidden w-full shadow">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th class="p-0 flex justify-end">
                        <a @click.prevent="openCreateModal"
                           class="bg-primary btn py-4 px-3 text-center text-primary-content rounded-none rounded-tr-lg">Add
                            Loan</a>
                    </th>
                </tr>
                </thead>
                <tbody v-if="loans.length > 0">
                <!-- row 1 -->
                <tr v-for="(loan, idx) in loans" :key="idx">
                    <td>{{ ((pagination.currentPage - 1) * pagination.limit) + (idx + 1) }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold">{{ loan.title }}</div>
                                <div class="text-sm opacity-50">{{ loan.details?.slice(0, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ loan.type }}</td>
                    <td>
                        {{ loan.formatted_amount }}
                        <br>
                        <span class="badge badge" :class="{'badge-success': loan.returned, 'badge-error': !loan.returned}">{{ loan.returned ? 'Returned' : 'Not returned' }}</span>
                    </td>
                    <td>{{ loan.created }}</td>
                    <th class="space-x-1">
                        <a @click.prevent="(event) => loanDetails(event, loan.id)"
                           class="btn-modal btn btn-outline btn-info"
                        >details</a>
                        <a @click.prevent="(event) => editLoan(event, loan.id)"
                           class="btn btn-outline btn-warning"
                        >edit</a>
                        <a @click.prevent="(event) => deleteLoan(event, loan.id)"
                           class="btn btn-outline btn-error">delete</a>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-middle py-5" v-if="loans.length <= 0">
            <progress class="progress w-56"></progress>
        </div>

        <div class="flex justify-center py-5">
            <Paginator :data-function="getLoans" :next-page="nextPage" :prev-page="prevPage"
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
import useLoan from "../../composables/loan";
import useMethod from "../../composables/method";
import useModal from "../../composables/modal";
import {onMounted} from "vue";
import Create from "./Create";
import Details from "./Details";
import Edit from "./Edit";
import Paginator from "../Paginator";
import Delete from "./Delete";

export default {
    name: "Loan",
    components: {Delete, Paginator, Details, Create, Edit},
    setup() {
        const {
            loans,
            loan,
            pagination,
            getLoans,
            getLoan,
            nextPage,
            prevPage
        } = useLoan();
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
            getLoans(1);
            getMethods();
        });

        const loanDetails = async (event, id) => {
            startLoading(event);
            await getLoan(id);
            openDetailsModal();
            stopLoading(event);
        };

        const editLoan = async (event, id) => {
            startLoading(event);
            await getLoan(id);
            openEditModal();
            stopLoading(event);
        };

        const deleteLoan = (event, id) => {
            startLoading(event);
            loan.value.id = id;
            openDeleteModal();
            stopLoading(event);
        };

        return {
            loans,
            modal,
            pagination,
            nextPage,
            prevPage,
            closeModal,
            openDeleteModal,
            openCreateModal,
            openDetailsModal,
            openEditModal,
            loanDetails,
            getLoans,
            editLoan,
            deleteLoan,
        };
    }
}
</script>

<style scoped>

</style>
