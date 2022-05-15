import {ref} from "vue";
import axios from "axios";

const loans = ref([]);
const pagination = ref({
    totalPage: 0,
    page: 1,
    currentPage: 1,
    limit: 15,
});
const loan = ref({
    title: '',
    id: 0,
});
const errors = ref([]);
const message = ref({
    message: '',
    error: false
});

export default function useLoan() {
    const getLoans = async (page = null) => {
        if (!page) {
            page = pagination.value.currentPage;
        }

        loans.value = [];
        const response = await axios.get('/loans?page=' + page + '&limit=' + pagination.value.limit);
        if (response.data.success) {
            pagination.value.currentPage = page;
            loans.value = response.data.data.loans;
            pagination.value.totalPage = Math.ceil(response.data.data.total / pagination.value.limit);
        }
    };

    const getLoan = async (id) => {
        if (loan.value.id === id) {
            return;
        }

        const response = await axios.get('/loans/' + id);
        if (response.data.success) {
            loan.value = response.data.data.loan;
        }
    };

    const updateLoan = async () => {
        clearMessages();

        try {
            const response = await axios.put('/loans/' + loan.value.id, loan.value);

            message.value.message = response.data.message;

            if (response.data.success) {
                message.value.error = false;
                return true;
            } else {
                message.value.error = true;
            }
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value.push(e.response.data.errors[key][0]);
                }
            }
        }

        return false;
    };

    const nextPage = async () => {
        ++pagination.value.page;

        if (pagination.value.page >= pagination.value.totalPage) {
            pagination.value.page = pagination.value.totalPage;
        }

        await getLoans(pagination.value.page);
    };

    const prevPage = async () => {
        --pagination.value.page;

        if (pagination.value.page <= 1) {
            pagination.value.page = 1;
        }

        await getLoans(pagination.value.page);
    };

    const saveLoan = async (data) => {
        clearMessages();

        try {
            const response = await axios.post('/loans', data);

            message.value.message = response.data.message;

            if (response.data.success) {
                message.value.error = false;
                return true;
            } else {
                message.value.error = true;
            }
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value.push(e.response.data.errors[key][0]);
                }
            }
        }

        return false;
    };

    const destroyLoan = async () => {
        clearMessages();

        const response = await axios.delete('/loans/' + loan.value.id);

        message.value.message = response.data.message;

        if (response.data.success) {
            message.value.error = false;
            return true;
        } else {
            message.value.error = true;
        }
    };

    const clearMessages = () => {
        errors.value = [];
        message.value.message = '';
        message.value.error = false;
    };

    return {
        loans,
        loan,
        getLoans,
        getLoan,
        nextPage,
        prevPage,
        message,
        errors,
        saveLoan,
        clearMessages,
        pagination,
        updateLoan,
        destroyLoan,
    }
}
