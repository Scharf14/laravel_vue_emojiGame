import axios from "axios";

const server = 'http://localhost:8000/api'
console.log(localStorage.getItem('token'))
const apiClient = axios.create({
    baseURL: server,
});

apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token')
        console.log('Interceptor token:', token)
        console.log('All localStorage:', localStorage)
        if (token) {
            config.headers.Authorization = token;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default apiClient
