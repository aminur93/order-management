/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/service/HttpService";

const state = {
    customers: [],
    customer: {},
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

    GET_ALL_CUSTOMER: (state, data) => {
        state.customers = data;
    },

    STORE_CUSTOMER: (state, data) => {
        if (state.customers.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_CUSTOMER: (state, data) => {
        state.customer = data;
    },

    UPDATE_CUSTOMER: (state, data) => {
        if (state.customers.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    DELETE_CUSTOMER: (state, {id, data}) => {
        if (id)
        {
            state.customers = state.customers.filter(item => {
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
    async GetAllCustomer({ commit }) {
        try {
            const result = await http().get("v1/admin/customer", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_CUSTOMER", result.data.data);
        } catch (err) {
            const errors = err.response.data.errors;
            const errorStatus = err.response.status;
            commit("SET_ERROR", { errors, errorStatus });
            throw err; // Re-throw the error to propagate it to the caller
        }
    },
    /*get all leave categories end*/

    /*store leave category start*/
    StoreCustomer: ({commit}, data) => {
        return http()
            .post("v1/admin/customer", data)
            .then((result) => {
                commit("STORE_CUSTOMER", result);
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
    GetSingleCustomer: ({commit}, id) => {
        return http()
            .get(`v1/admin/customer/${id}`)
            .then((result) => {
                commit("GET_SINGLE_CUSTOMER", result.data.data);
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
    UpdateCustomer: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/customer/${id}`, data)
            .then((result) => {
                commit("UPDATE_CUSTOMER", result);
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
    DeleteCustomer: ({commit}, id) => {
        return http()
            .delete(`v1/admin/customer/${id}`)
            .then((result) => {
                commit("DELETE_CUSTOMER", {id:id, data:result});
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