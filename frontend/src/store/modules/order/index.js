/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/service/HttpService";

const state = {
    orders: [],
    order: {},
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

    GET_ALL_ORDER: (state, data) => {
        state.orders = data;
    },

    STORE_ORDER: (state, data) => {
        if (state.orders.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_ORDER: (state, data) => {
        state.order = data;
    },

    UPDATE_ORDER: (state, data) => {
        if (state.orders.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    DELETE_ORDER: (state, {id, data}) => {
        if (id)
        {
            state.orders = state.orders.filter(item => {
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
    async GetAllOrder({ commit }) {
        try {
            const result = await http().get("v1/admin/order", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_ORDER", result.data.data);
        } catch (err) {
            const errors = err.response.data.errors;
            const errorStatus = err.response.status;
            commit("SET_ERROR", { errors, errorStatus });
            throw err; // Re-throw the error to propagate it to the caller
        }
    },
    /*get all leave categories end*/

    /*store leave category start*/
    StoreOrder: ({commit}, data) => {
        return http()
            .post("v1/admin/order", data)
            .then((result) => {
                commit("STORE_ORDER", result);
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
    GetSingleOrder: ({commit}, id) => {
        return http()
            .get(`v1/admin/order/${id}`)
            .then((result) => {
                commit("GET_SINGLE_ORDER", result.data.data);
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
    UpdateOrder: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/order/${id}`, data)
            .then((result) => {
                commit("UPDATE_ORDER", result);
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
    DeleteOrder: ({commit}, id) => {
        return http()
            .delete(`v1/admin/order/${id}`)
            .then((result) => {
                commit("DELETE_ORDER", {id:id, data:result});
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