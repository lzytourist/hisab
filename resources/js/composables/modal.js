import {ref} from "vue";

const initialModal = {
    create: false,
    edit: false,
    destroy: false,
    details: false,
};

const modal = ref(initialModal);

export default function useModal() {

    const openCreateModal = () => {
        modal.value = {
            ...initialModal,
            create: true,
        };
    };

    const openEditModal = () => {
        modal.value = {
            ...initialModal,
            edit: true,
        };
    };

    const openDeleteModal = () => {
        modal.value = {
            ...initialModal,
            destroy: true,
        };
    };

    const openDetailsModal = () => {
        modal.value = {
            ...initialModal,
            details: true,
        };
    };

    const closeModal = () => {
        modal.value = initialModal;
    };

    const startLoading = (event) => {
        event.target.classList.add('loading');
    };

    const stopLoading = (event) => {
        event.target.classList.remove('loading');
    };

    return {
        modal,
        closeModal,
        openCreateModal,
        openDeleteModal,
        openDetailsModal,
        openEditModal,
        startLoading,
        stopLoading,
    };
}
