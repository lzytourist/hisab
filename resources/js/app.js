require('./bootstrap');

import App from './components/App';
import router from "./router";

const {createApp} = require("vue");

createApp({
    components: {
        App,
    }
})
    .use(router)
    .mount('#app');
