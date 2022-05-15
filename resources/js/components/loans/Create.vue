<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.create}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Add Loan</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <Errors :errors="errors"/>
            <Message :message="message"/>

            <form method="post" @submit.prevent="addLoan">
                <div class="mb-4 form-group">
                    <label for="title" class="label">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" v-model="loan.title" id="title" class="input w-full"
                           placeholder="Enter title">
                </div>
                <div class="mb-4 form-group">
                    <label for="amount" class="label">Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" v-model="loan.amount" id="amount" class="input w-full"
                           placeholder="Enter amount">
                </div>
                <div class="mb-4 form-group">
                    <label for="type" class="label">Loan Given/Taken <span class="text-red-500">*</span></label>
                    <select id="type" class="select w-full" v-model="loan.type">
                        <option value="Given">Given</option>
                        <option value="Taken">Taken</option>
                    </select>
                </div>
                <div class="mb-4 form-group">
                    <label class="label cursor-pointer">
                        <span class="label-text">Returned</span>
                        <input type="checkbox" class="toggle toggle-primary" v-model="loan.returned" />
                    </label>
                </div>
                <div class="mt-4">
                    <input type="submit" value="save" class="btn btn-outline btn-primary btn-block" :class="{loading: loading}">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import useLoan from "../../composables/loan";
import useMethod from "../../composables/method";
import useModal from "../../composables/modal";
import {reactive, ref} from "vue";
import Errors from "../Errors";
import Message from "../Message";

export default {
    name: "Create",
    components: {Message, Errors},
    setup() {
        const {errors, message, saveLoan, getLoans, clearMessages} = useLoan();
        const {methods} = useMethod();
        const {modal, openCreateModal, closeModal} = useModal();

        const loading = ref(false);

        const initialLoan = {
            title: '',
            amount: 0,
            type: 'Given',
            returned: false
        };
        const loan = reactive(initialLoan);

        const addLoan = async () => {
            loading.value = true;

            const success = await saveLoan(loan);
            if (success) {
                await getLoans(1);

                closeModal();
                clearMessages();

                for (const [key, value] in Object.entries(initialLoan)) {
                    loan[key] = value;
                }
            }

            loading.value = false;
        };

        return {
            errors,
            message,
            loan,
            methods,
            loading,
            modal,
            openCreateModal,
            closeModal,
            addLoan,
        };
    }
}
</script>

<style scoped>

</style>
