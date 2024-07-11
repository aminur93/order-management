/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http, httpFile} from "@/service/HttpService";

const state = {
    products: [],
    product: {},
    success_message: "",
    errors: {},
    error_message: "",
    error_status: "",
    success_status: "",
}

/* -------------------------------------------------------------------------- */
/*                              Mutations Define                              */
/* -------------------------------------------------------------------------- */
const mutations = {

    GET_ALL_PRODUCT: (state, data) => {
        state.products = data;
    },

    STORE_PRODUCT: (state, data) => {
        if (state.products.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_PRODUCT: (state, data) => {
        state.product = data;
    },

    UPDATE_PRODUCT: (state, data) => {
        if (state.products.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    DELETE_PRODUCT: (state, {id, data}) => {
        if (id)
        {
            state.products = state.products.filter(item => {
                return item.id !== id;
            })

            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    SET_ERROR(state, { errors, errorStatus }) {
        state.errors = errors;
        state.error_status = errorStatus;
    }
}

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {

    /*get all leave categories start*/
    async GetAllProduct({ commit }) {
        try {
            const result = await http().get("v1/admin/products", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_PRODUCT", result.data.data);
        } catch (err) {
            const errors = err.response.data.errors;
            const errorStatus = err.response.status;
            commit("SET_ERROR", { errors, errorStatus });
            throw err;
        }
    },
    /*get all leave categories end*/

    /*store leave category start*/
    StoreProduct: ({commit}, data) => {
        return httpFile()
            .post("v1/admin/products", data)
            .then((result) => {
                commit("STORE_PRODUCT", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*store leave category end*/

    /*get single leave category start*/
    GetSingleProduct: ({commit}, id) => {
        return http()
            .get(`v1/admin/products/${id}`)
            .then((result) => {
                commit("GET_SINGLE_PRODUCT", result.data.data);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*get single leave category end*/

    /*update leave category start*/
    UpdateProduct: ({commit}, {id, data}) => {
        return httpFile()
            .post(`v1/admin/products/${id}`, data)
            .then((result) => {
                commit("UPDATE_PRODUCT", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*update leave category end*/

    /*destroy leave category start*/
    DeleteProduct: ({commit}, id) => {
        return http()
            .delete(`v1/admin/products/${id}`)
            .then((result) => {
                commit("DELETE_PRODUCT", {id:id, data:result});
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*destroy leave category end*/
}

/* -------------------------------------------------------------------------- */
/*                               Getters Define                               */
/* -------------------------------------------------------------------------- */
const getters = {}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}