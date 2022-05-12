import {reactive, ref} from "vue";
import axios from "axios";

const balances = ref([]);
const pagination = ref({
    totalPage: 0,
    page: 1,
    currentPage: 1,
    limit: 15,
});
const balance = ref({
    title: '',
    id: 0,
});
const errors = ref([]);
const message = ref({
    message: '',
    error: false
});

export default function useBalance() {
    const getBalances = async (page = null) => {
        if (!page) {
            page = pagination.value.currentPage;
        }

        balances.value = [];
        const response = await axios.get('/balances?page=' + page + '&limit=' + pagination.value.limit);
        if (response.data.success) {
            pagination.value.currentPage = page;
            balances.value = response.data.data.balances;
            pagination.value.totalPage = Math.ceil(response.data.data.total / pagination.value.limit);
        }
    };

    const getBalance = async (id) => {
        if (balance.value.id === id) {
            return;
        }

        const response = await axios.get('/balances/' + id);
        if (response.data.success) {
            balance.value = response.data.data.balance;
        }
    };

    const updateBalance = async () => {
        clearMessages();

        try {
            const response = await axios.put('/balances/' + balance.value.id, balance.value);

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

        await getBalances(pagination.value.page);
    };

    const prevPage = async () => {
        --pagination.value.page;

        if (pagination.value.page <= 1) {
            pagination.value.page = 1;
        }

        await getBalances(pagination.value.page);
    };

    const saveBalance = async (data) => {
        clearMessages();

        try {
            const response = await axios.post('/balances', data);

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

    const destroyBalance = async () => {
        clearMessages();

        const response = await axios.delete('/balances/' + balance.value.id);

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
        balances,
        balance,
        getBalances,
        getBalance,
        nextPage,
        prevPage,
        message,
        errors,
        saveBalance,
        clearMessages,
        pagination,
        updateBalance,
        destroyBalance,
    }
}
