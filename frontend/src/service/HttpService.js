import store from "@/store";
import axios from "axios";

export function http(){
    return axios.create({
        baseURL: store.state.apiUrl,
        headers: {
            'Accept' : "application/json",
            'Content-Type' : 'application/json',
            'Authorization' : 'Bearer '+ store.state.token
        }
    });
}

export function httpFile(){
    return axios.create({
        baseURL: store.state.apiUrl,
        headers: {
            'Accept': 'application/json',
            'Content-Type' : 'multipart/form-data',
            'Authorization' : 'Bearer '+ store.state.token
        }
    });
}