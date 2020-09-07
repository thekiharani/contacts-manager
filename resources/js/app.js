import Vue from 'vue';
import router from './router';
import App from "./App";

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
