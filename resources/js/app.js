
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'fullcalendar';
import VeeValidate from "vee-validate";

window.Vue = require('vue');
window.numeral = require('numeral');
window.toastr = require('toastr');
window.swal = require('sweetalert');
window.Swal = require('sweetalert2')
toastr.options = {
    "closeButton": false,
    "progressBar": true,
  }
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(VeeValidate, {
    classes: true,
    classNames: {
        valid: "is-valid",
        invalid: "is-invalid"
    }
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('indicadores-component', require('./components/IndicadoresComponent.vue').default);
Vue.component('operaciones-component', require('./components/OperacionesComponent.vue').default);
Vue.component('tareas-component', require('./components/TareasComponent.vue').default);
Vue.component('years-component', require('./components/YearsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
