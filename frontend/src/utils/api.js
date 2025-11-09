import axios from "axios";

const server = 'http://localhost:8000/api'

const apiClient = axios.create({
    baseURL: server,
    headers: {
        'Authorization': localStorage.getItem('token')
    }
});

export default apiClient
