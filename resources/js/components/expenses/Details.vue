<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.details}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Expense Details</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <div class="py-4">
                <div class="flex align-super">
                    <h1 class="font-light text-4xl mb-2">{{ expense.title }}</h1>
                    <p class="ml-1 badge badge-primary">{{ expense.method }}</p>
                </div>
                <blockquote class="text-xs font-bold mb-2 text-base-content">{{ expense.created }}</blockquote>
                <p class="font-bold mb-2">{{ expense.formatted_amount }}</p>
                <p>{{ expense.details }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import useModal from "../../composables/modal";
import useExpense from "../../composables/expense";

export default {
    name: "Details",

    setup() {
        const {expense} = useExpense();
        const {modal, closeModal} = useModal();

        return {
            expense,
            modal,
            closeModal
        };
    }
}
</script>
