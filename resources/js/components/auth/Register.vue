<template>
<div class="container mx-auto py-5">
    <div class="flex justify-center">
        <div class="lg:w-2/5 md:w-2/3 w-full">
            <div class="card bg-white text-base-content">
                <div class="card-body">
                    <h1 class="text-center text-4xl font-light uppercase">Register new account</h1>
                    <Errors :errors="errors" />
                    <Message :message="message" />
                    <form @submit.prevent="saveUser" method="post">
                        <div class="mt-5 mb-4 form-group">
                            <label for="name" class="label">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" v-model="user.name" id="name" class="input w-full" placeholder="Enter your full name">
                        </div>
                        <div class="mb-4 form-group">
                            <label for="email" class="label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" v-model="user.email" id="email" class="input w-full" placeholder="Enter email address">
                        </div>
                        <div class="mb-4 form-group">
                            <label for="password" class="label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" v-model="user.password" id="password" class="input w-full" placeholder="Enter password">
                        </div>
                        <div class="mb-4 form-group">
                            <label for="password_confirmation" class="label">Re-enter Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" v-model="user.password_confirmation" id="password_confirmation" class="input w-full" placeholder="Re-enter password">
                        </div>
                        <div class="mb-4 form-group">
                            <input type="submit" :value="button" class="btn btn-primary">
                        </div>
                    </form>

                    <div class="mt-4">
                        <p>Already have an account? <router-link :to="{name: 'login'}" class="text-secondary">Login</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import useAuth from "../../composables/auth";
import {reactive, ref} from "vue";
import Errors from "../Errors";
import Message from "../Message";

export default {
    name: "Register",
    components: {Message, Errors},
    setup() {
        const {errors, message, createUser} = useAuth();
        const user = reactive({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });

        const button = ref('register');

        const saveUser = async () => {
            button.value = 'registering';
            await createUser(user);
            button.value = 'save';
        };

        return {
            user,
            errors,
            message,
            button,
            saveUser,
        }
    }
}
</script>

<style scoped>

</style>
