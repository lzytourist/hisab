<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.destroy}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Are you sure?</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <div class="modal-action">
                <a @click.prevent="closeModal" class="btn btn-success">Cancel</a>
                <a @click.prevent="deleteBalance" class="btn btn-error">Delete</a>
            </div>
        </div>
    </div>
</template>

<script>
import useBalance from "../../composables/balance";
import useModal from "../../composables/modal";
import {ref} from "vue";
import Message from "../Message";

export default {
    name: "Delete",
    components: {Message},
    setup() {
        const {errors, message, destroyBalance, getBalances, clearMessages} = useBalance();
        const {modal, openDeleteModal, closeModal} = useModal();

        const loading = ref(false);

        const deleteBalance = async () => {
            loading.value = true;

            const success = await destroyBalance();
            if (success) {
                await getBalances();

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
            deleteBalance,
        };
    }
}
</script>

<style scoped>

</style>
