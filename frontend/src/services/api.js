import axios from "axios";

/*
|--------------------------------------------------------------------------
| Base URLs (auto from env)
|--------------------------------------------------------------------------
*/

export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/api";

/*
|--------------------------------------------------------------------------
| Axios Instance
|--------------------------------------------------------------------------
*/

const api = axios.create({
    baseURL: API_BASE_URL,
    headers: { Accept: "application/json" },
    withCredentials: false,
});

/*
|--------------------------------------------------------------------------
| Token Interceptor
|--------------------------------------------------------------------------
*/

api.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
});


export default api;
