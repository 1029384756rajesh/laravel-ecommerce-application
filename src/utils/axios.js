import axios from "axios"

axios.defaults.baseURL = process.env.REACT_APP_BASE_URL

axios.interceptors.request.use(config => {

    if(config.method != "get" && config.method != "post") {
        config.url += config.url.includes("?") ? `&_method=${config.method}` : `?_method=${config.method}`
        config.method = "post"
    }

    if(localStorage.getItem("authToken")) {
        config.headers.Authorization = `Bearer ${localStorage.getItem("authToken")}`
    }

    return config

}, error => Promise.reject(error))

axios.interceptors.response.use(response => {

    if(response.status === 401) {
        localStorage.removeItem("authToken")
        window.location.href = "/"
    }

    return response

}, error => Promise.reject(error))

export default axios