import {ref} from "vue";
import axios from "axios";

const expenses = ref([]);
const pagination = ref({
    totalPage: 0,
    page: 1,
    currentPage: 1,
    limit: 15,
});
const expense = ref({
    title: '',
    id: 0,
});
const errors = ref([]);
const message = ref({
    message: '',
    error: false
});

export default function useExpense() {
    const getExpenses = async (page = null) => {
        if (!page) {
            page = pagination.value.currentPage;
        }

        expenses.value = [];
        const response = await axios.get('/expenses?page=' + page + '&limit=' + pagination.value.limit);
        if (response.data.success) {
            pagination.value.currentPage = page;
            expenses.value = response.data.data.expenses;
            pagination.value.totalPage = Math.ceil(response.data.data.total / pagination.value.limit);
        }
    };

    const getExpense = async (id) => {
        if (expense.value.id === id) {
            return;
        }

        const response = await axios.get('/expenses/' + id);
        if (response.data.success) {
            expense.value = response.data.data.expense;
        }
    };

    const updateExpense = async () => {
        clearMessages();

        try {
            const response = await axios.put('/expenses/' + expense.value.id, expense.value);

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

        await getExpenses(pagination.value.page);
    };

    const prevPage = async () => {
        --pagination.value.page;

        if (pagination.value.page <= 1) {
            pagination.value.page = 1;
        }

        await getExpenses(pagination.value.page);
    };

    const saveExpense = async (data) => {
        clearMessages();

        try {
            const response = await axios.post('/expenses', data);

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

    const destroyExpense = async () => {
        clearMessages();

        const response = await axios.delete('/expenses/' + expense.value.id);

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
        expenses,
        expense,
        getExpenses,
        getExpense,
        nextPage,
        prevPage,
        message,
        errors,
        saveExpense,
        clearMessages,
        pagination,
        updateExpense,
        destroyExpense,
    }
}
