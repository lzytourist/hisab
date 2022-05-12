<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.create}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Add Expense</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <Errors :errors="errors"/>
            <Message :message="message"/>

            <form method="post" @submit.prevent="addExpense">
                <div class="mb-4 form-group">
                    <label for="title" class="label">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" v-model="expense.title" id="title" class="input w-full"
                           placeholder="Enter title">
                </div>
                <div class="mb-4 form-group">
                    <label for="details" class="label">Details <span class="text-red-500">*</span></label>
                    <textarea class="textarea w-full" placeholder="Details" v-model="expense.details"></textarea>
                </div>
                <div class="mb-4 form-group">
                    <label for="amount" class="label">Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" v-model="expense.amount" id="amount" class="input w-full"
                           placeholder="Enter amount">
                </div>
                <div class="mb-4 form-group">
                    <label for="method" class="label">Method <span class="text-red-500">*</span></label>
                    <select id="method" class="select w-full" v-model="expense.method_id">
                        <option disabled selected value="0">Select Method</option>
                        <option
                            v-for="(method, idx) in methods"
                            :key="idx"
                            :value="method.id"
                        >
                            {{ method.name }}
                        </option>
                    </select>
                </div>
                <div class="mt-4">
                    <input type="submit" value="save" class="btn btn-outline btn-primary btn-block" :class="{loading: loading}">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import useExpense from "../../composables/expense";
import useMethod from "../../composables/method";
import useModal from "../../composables/modal";
import {reactive, ref} from "vue";
import Errors from "../Errors";
import Message from "../Message";

export default {
    name: "Create",
    components: {Message, Errors},
    setup() {
        const {errors, message, saveExpense, getExpenses, clearMessages} = useExpense();
        const {methods} = useMethod();
        const {modal, openCreateModal, closeModal} = useModal();

        const loading = ref(false);

        const expense = reactive({
            title: '',
            details: '',
            amount: 0,
            method_id: 0
        });

        const addExpense = async () => {
            loading.value = true;

            const success = await saveExpense(expense);
            if (success) {
                await getExpenses(1);

                closeModal();
                clearMessages();
            }

            loading.value = false;
        };

        return {
            errors,
            message,
            expense,
            methods,
            loading,
            modal,
            openCreateModal,
            closeModal,
            addExpense,
        };
    }
}
</script>

<style scoped>

</style>
