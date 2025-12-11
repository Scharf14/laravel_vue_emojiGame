import axios from "axios";

const server = 'http://localhost:8000/api'

const apiClient = axios.create({
    baseURL: server,

});

apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token')
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
