<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.details}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Loan Details</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <div class="py-4">
                <div class="flex align-super">
                    <h1 class="font-light text-4xl mb-2">{{ loan.title }}</h1>
                    <p class="badge badge" :class="{'badge-success': loan.type === 'Given', 'badge-error': loan.type === 'Taken'}">{{ loan.type }}</p>
                </div>
                <p>Returned: {{ loan.returned ? "Yes" : "No"}}</p>
                <blockquote class="text-xs font-bold mb-2 text-base-content">{{ loan.created }}</blockquote>
                <p class="font-bold mb-2">{{ loan.formatted_amount }}</p>
                <p>{{ loan.details }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import useModal from "../../composables/modal";
import useLoan from "../../composables/loan";

export default {
    name: "Details",

    setup() {
        const {loan} = useLoan();
        const {modal, closeModal} = useModal();

        return {
            loan,
            modal,
            closeModal
        };
    }
}
</script>
