<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.destroy}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Are you sure?</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <div class="modal-action">
                <a @click.prevent="closeModal" class="btn btn-success">Cancel</a>
                <a @click.prevent="deleteExpense" class="btn btn-error">Delete</a>
            </div>
        </div>
    </div>
</template>

<script>
import useExpense from "../../composables/expense";
import useModal from "../../composables/modal";
import {ref} from "vue";
import Message from "../Message";

export default {
    name: "Delete",
    components: {Message},
    setup() {
        const {errors, message, destroyExpense, getExpenses, clearMessages} = useExpense();
        const {modal, openDeleteModal, closeModal} = useModal();

        const loading = ref(false);

        const deleteExpense = async () => {
            loading.value = true;

            const success = await destroyExpense();
            if (success) {
                await getExpenses();

                closeModal();
                clearMessages();
            }

            loading.value = false;
        };

        return {
            errors,
            message,
            loading,
            modal,
            openDeleteModal,
            closeModal,
            deleteExpense,
        };
    }
}
</script>

<style scoped>

</style>
