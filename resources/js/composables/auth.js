import {ref} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";

const auth = ref(false);
const user = ref({});
const errors = ref([]);
const message = ref({
    message: '',
    error: false,
});

export default function useAuth() {
    const router = useRouter();

    const getAuth = async () => {
        auth.value = false;
        try {
            const response = await axios.get('/user');

            user.value = response.data;
            auth.value = true;

            if (router.currentRoute.value.name === 'login' || router.currentRoute.value.name === 'register') {
                await router.push({name: 'dashboard'});
            }
        } catch (e) {
            if (router.currentRoute.value.name !== 'register') {
                await router.push({name: "login"});
            }
        }
    };

    const createUser = async (data) => {
        clearMessages();

        try {
            const response = await axios.post('/register', data);
            message.value.message = response.data.message;

            if (response.data.success) {
                localStorage.setItem('token', response.data.data.token);
                message.value.error = false;

                setTimeout(() => {
                    window.open('/dashboard', '_self');
                }, 1000);
            } else {
                message.value.error = true;
            }
        } catch (e) {
            if (e.response.status === 422) {
                updateErrors(e);
            }
        }
    };

    const updateErrors = (e) => {
        for (const key in e.response.data.errors) {
            errors.value.push(e.response.data.errors[key][0]);
        }
    };

    const loginUser = async (data) => {
        clearMessages();

        try {
            const response = await axios.post('/login', data);
            message.value.message = response.data.message;

            if (response.data.success) {
                localStorage.setItem('token', response.data.data.token);
                message.value.error = false;

                setTimeout(() => {
                    window.open('http://127.0.0.1:8000/dashboard', '_self');
                }, 1500);
            } else {
                message.value.error = true;
            }
        } catch (e) {
            if (e.response.status === 422) {
                updateErrors(e);
            }
        }
    };

    const logout = async () => {
        try {
            await axios.post('/logout');
            localStorage.removeItem('token');
            window.open('http://127.0.0.1:8000', '_self');
        } catch (e) {}
    };

    const clearMessages = () => {
        errors.value = [];
        message.value.message = '';
    };

    return {
        auth,
        errors,
        message,
        user,
        createUser,
        getAuth,
        loginUser,
        logout,
    }
}
