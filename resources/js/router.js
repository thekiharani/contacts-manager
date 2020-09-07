import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from "./components/Home";
import Contacts from "./components/Contacts";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {path: '/', component: Home},
        {path: '/contacts', component: Contacts},
    ],
    mode: 'history'
});
