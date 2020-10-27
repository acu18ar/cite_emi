require('./bootstrap');
window.Vue = require('vue');
window.moment = require('moment');
window.moment.locale('es');
window.accounting = require('accounting');

axios.interceptors.response.use((response) => {
    return response;
}, function (error) {
    return Promise.reject(error.response);
});

/*componentes adicionales*/
import vSelect from 'vue-select';
import GridLoader from "vue-spinner/src/GridLoader.vue";
import PulseLoader from "vue-spinner/src/PulseLoader.vue";
import SkewLoader from "vue-spinner/src/SkewLoader.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import Loading from "./components/Loading.vue";

/* Registro de componentes */
Vue.component('loading', Loading);
Vue.component('grid-loader', GridLoader);
Vue.component('pulse-loader', PulseLoader);
Vue.component('skew-loader', SkewLoader);
Vue.component('moon-loader', MoonLoader);
Vue.component('v-select', vSelect);

