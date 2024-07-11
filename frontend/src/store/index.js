import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";

import state from './state';
import * as getters from "./getters";
import * as mutations from "./mutations";
import * as actions from "./actions";

/*module import start*/
import customer from "@/store/modules/customer";
import product from "@/store/modules/product";
import order from "@/store/modules/order";
/*module import end*/

const store = createStore({
    state,
    getters,
    mutations,
    actions,

    modules: {
        customer,
        product,
        order
    },

    plugins: [
        createPersistedState({
            paths: ["token", "user", "permissions","role"]
        })
    ]
});

export default store;