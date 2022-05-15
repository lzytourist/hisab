<template>
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle"/>
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="w-full navbar bg-base-300">
                <div class="container mx-auto">
                    <div class="flex-none lg:hidden">
                        <label for="my-drawer-3" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 class="inline-block w-6 h-6 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <router-link :to="{name: 'dashboard'}" active-class="active" class="flex-1 px-2 mx-2 text-4xl">
                        his<span class="text-primary">AB</span>
                    </router-link>
                    <div class="flex-none hidden lg:block">
                        <ul class="menu menu-horizontal">
                            <!-- Navbar menu content here -->
                            <li v-for="(item, idx) in navigation" :key="idx">
                                <router-link :to="{name: item.link}">{{ item.name }}</router-link>
                            </li>
                            <li class="dropdown">
                                <span tabindex="0" class="">Account</span>
                                <ul tabindex="0" class="dropdown-content menu shadow bg-base-100 rounded-box w-52">
                                    <li><a>{{ user?.name }}</a></li>
                                    <li><a @click.prevent="logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Page content here -->
            <router-view/>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-3" class="drawer-overlay"></label>
            <ul class="menu p-4 overflow-y-auto w-80 bg-base-100">
                <!-- Sidebar content here -->
                <li v-for="(item, idx) in navigation" :key="idx">
                    <router-link :to="{name: item.link}">{{ item.name }}</router-link>
                </li>
            </ul>

        </div>
    </div>
</template>

<script>
import useAuth from "../composables/auth";

export default {
    name: "Header",
    setup() {
        const navigation = [
            {
                name: 'Dashboard',
                link: 'dashboard'
            },
            {
                name: 'Balance',
                link: 'balances.index'
            },
            {
                name: 'Expense',
                link: 'expenses.index'
            },
            {
                name: 'Notes',
                link: 'notes.index'
            },
            {
                name: 'Tasks',
                link: 'tasks.index'
            },
            {
                name: 'Loans',
                link: 'loans.index'
            }
        ];

        const {logout, user} = useAuth();

        return {
            navigation,
            logout,
            user,
        }
    }
}
</script>

<style scoped>
.router-link-active {
    background-color: hsl(var(--p));
    color: hsl(var(--pc));
}
</style>
