<template>
    <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': modal.details}">
        <div class="modal-box bg-base-200 text-base-content">
            <h3 class="font-bold text-lg">Balance Details</h3>
            <a @click.prevent="closeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</a>

            <div class="py-4">
                <div class="flex align-super">
                    <h1 class="font-light text-4xl mb-2">{{ balance.title }}</h1>
                    <p class="ml-1 badge badge-primary">{{ balance.method }}</p>
                </div>
                <blockquote class="text-xs font-bold mb-2 text-base-content">{{ balance.created }}</blockquote>
                <p class="font-bold mb-2">{{ balance.formatted_amount }}</p>
                <p>{{ balance.details }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import useModal from "../../composables/modal";
import useBalance from "../../composables/balance";

export default {
    name: "Details",

    setup() {
        const {balance} = useBalance();
        const {modal, closeModal} = useModal();

        return {
            balance,
            modal,
            closeModal
        };
    }
}
</script>
