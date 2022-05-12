window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.withCredentials = true;
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
window.axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
