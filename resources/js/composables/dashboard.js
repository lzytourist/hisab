import {ref} from "vue";

const stats = ref({
    balance: {
        current: {
            amount: 0,
            period: 'January'
        },
        total: {
            amount: 0,
            period: 'December to January'
        }
    },
    expense: {
        current: {
            amount: 0,
            period: 'January'
        },
        total: {
            amount: 0,
            period: 'December to January'
        }
    },
    account: {
        current: 0,
        total: 0
    }
});

export default function useDashboard() {
    const getStats = async () => {
        const response  = await axios.get('/dashboard/stats');
        if (response.data.success) {
            stats.value = response.data.data;
        }
    };

    return {
        stats,
        getStats,
    };
}
