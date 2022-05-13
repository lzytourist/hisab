<template>
<div class="container mx-auto">
    <div class="my-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">

            <div class="stat shadow-lg rounded-md place-items-center">
                <div class="stat-title">Balance</div>
                <div class="stat-value">{{ stats?.balance.current.amount }}</div>
                <div class="stat-desc">{{ stats?.balance.current.period }}</div>
            </div>

            <div class="stat shadow-lg rounded-md place-items-center bg-error-content">
                <div class="stat-title">Expense</div>
                <div class="stat-value text-error">{{ stats?.expense.current.amount }}</div>
                <div class="stat-desc text-error">{{ stats?.expense.current.period }}</div>
            </div>

            <div class="stat shadow-lg rounded-md place-items-center">
                <div class="stat-title">Total Balance</div>
                <div class="stat-value">{{ stats?.balance.total.amount }}</div>
                <div class="stat-desc">{{ stats?.balance.total.period }}</div>
            </div>

            <div class="stat shadow-lg rounded-md place-items-center bg-error">
                <div class="stat-title">Total Expense</div>
                <div class="stat-value text-error-content">{{ stats?.expense.total.amount }}</div>
                <div class="stat-desc text-error-content">{{ stats?.expense.total.period }}</div>
            </div>

        </div>

        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-2">

                <div class="stat place-items-center shadow-lg bg-success rounded-md">
                    <div class="stat-title">Money in Hand</div>
                    <div class="stat-value text-success-content">{{ stats?.account.current }}</div>
                    <div class="stat-desc">{{ stats?.balance.current.period }}</div>
                </div>

                <div class="stat place-items-center shadow-lg rounded-md">
                    <div class="stat-title">Money in Hand</div>
                    <div class="stat-value text-success">{{ stats?.account.total }}</div>
                    <div class="stat-desc">{{ stats?.balance.total.period }}</div>
                </div>

        </div>
    </div>
</div>
</template>

<script>
import {onMounted} from "vue";
import useDashboard from "../../composables/dashboard";

export default {
    name: "DashboardIndex",
    setup() {
        const {stats, getStats} = useDashboard();

        onMounted(() => {
            getStats();
        });

        return {
            stats,
        };
    }
}
</script>

<style scoped>

</style>
