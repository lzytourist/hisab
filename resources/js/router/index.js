import {createRouter, createWebHistory} from "vue-router";
import DashboardIndex from "../components/Dashboard/DashboardIndex";
import BalanceIndex from "../components/balances/Balance";
import ExpenseIndex from "../components/expenses/Expense";
import NoteIndex from "../components/notes/NoteIndex";
import TaskIndex from "../components/tasks/TaskIndex";
import Login from "../components/auth/Login";
import Register from "../components/auth/Register";

const routes = [
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardIndex
    },
    {
        path: "/balances",
        name: "balances.index",
        component: BalanceIndex
    },
    {
        path: "/expenses",
        name: "expenses.index",
        component: ExpenseIndex
    },
    {
        path: "/notes",
        name: "notes.index",
        component: NoteIndex
    },
    {
        path: "/tasks",
        name: "tasks.index",
        component: TaskIndex
    },
    {
        path: "/login",
        name: "login",
        component: Login
    },
    {
        path: "/register",
        name: "register",
        component: Register
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
});
