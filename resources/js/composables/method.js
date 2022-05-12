import {ref} from "vue";
import axios from "axios";

const methods = ref([]);

export default function useMethod() {

    const getMethods = async () => {
        const response  = await axios.get('/methods');
        if (response.data.success) {
            methods.value = response.data.data.methods;
        }
    };

    return {
        methods,
        getMethods,
    };
}
