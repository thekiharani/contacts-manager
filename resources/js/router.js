import Vue from 'vue';
import VueRouter from 'vue-router';
import Contacts from "./views/Contacts";
import Groups from "./views/Groups";
import PersonalMessage from "./views/PersonalMessage";
import GroupMessage from "./views/GroupMessage";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {path: '/', component: Contacts},
        {path: '/contacts', component: Contacts},
        {path: '/groups', component: Groups},
        {path: '/personal_message', component: PersonalMessage},
        {path: '/group_message', component: GroupMessage}
    ],
    mode: 'history'
});
