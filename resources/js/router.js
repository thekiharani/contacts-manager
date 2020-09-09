import Vue from 'vue';
import VueRouter from 'vue-router';
import Contacts from "./views/Contacts";
import Groups from "./views/Groups";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {path: '/', component: Contacts},
        {path: '/contacts', component: Contacts},
        {path: '/groups', component: Groups},
    ],
    mode: 'history'
});
