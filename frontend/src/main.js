import { createApp } from 'vue'
import App from './App.vue'
import router from "@/router";
import store from "@/store";
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'

loadFonts()

/*vue sweet alert start*/
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
/*vue sweet alert end*/

createApp(App)
    .use(router)
    .use(store)
    .use(vuetify)
    .use(VueSweetalert2)
    .mount('#app')
