<template>
    <div class="container mx-auto py-5">
        <div class="flex justify-center">
            <div class="lg:w-2/5 md:w-2/3 w-full">
                <div class="card bg-white text-base-content">
                    <div class="card-body">
                        <h1 class="text-center text-4xl font-light uppercase mb-4">Login to your account</h1>
                        <Errors :errors="errors"/>
                        <Message :message="message"/>
                        <form @submit.prevent="login" method="post">
                            <div class="mb-4 form-group">
                                <label for="email" class="label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" v-model="user.email" id="email" class="input w-full"
                                       placeholder="Enter email address">
                            </div>
                            <div class="mb-4 form-group">
                                <label for="password">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" v-model="user.password" id="password"
                                       class="input w-full" placeholder="Enter password">
                            </div>
                            <div class="mb-4 form-group">
                                <input type="submit" :value="button" class="btn btn-primary">
                            </div>
                        </form>

                        <div class="mt-4">
                            <p>Do not have an account?
                                <router-link :to="{name: 'register'}" class="text-secondary">Register</router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive, ref} from "vue";
import useAuth from "../../composables/auth";
import Errors from "../Errors";
import Message from "../Message";

export default {
    name: "Login",
    components: {Message, Errors},
    setup() {
        const {errors, message, loginUser} = useAuth();

        const user = reactive({
            email: '',
            password: '',
        });

        const button = ref('login');

        const login = async () => {
            button.value = 'logging in..'
            await loginUser(user);
            button.value = 'login';
        };

        return {
            user,
            button,
            errors,
            login,
            message,
        }
    }
}
</script>
