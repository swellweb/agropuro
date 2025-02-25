import axios from 'axios';
debugger;
axios.defaults.baseURL = 'http://localhost:8000';
// Configura Axios per inviare automaticamente i cookie e il token CSRF
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Funzione per ottenere il cookie CSRF da Sanctum
export const getCsrfCookie = () => {
    return axios.get('http://localhost:8000/sanctum/csrf-cookie');
};

// Export di default Axios per usarlo nei componenti Vue
export default axios;
