import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from '../components/dashboard/Dashboard';
import UserProfile from '../components/users/UserProfile';
import Admin from '../components/admin/Admin';

Vue.use(Router);

export default new Router({
    mode: 'history',

    routes: [
        {
            path: '*',
            redirect: 'bi/dashboard'
        },
        {
            path: '/bi/',
            redirect: 'bi/dashboard'
        },
        {
            name: 'bi',
            path: '/bi/dashboard',
            component: Dashboard
        },

        {
            path: '/bi/admin',
            component: Admin
        },

        {
            path: '/bi/user-profile',
            component: UserProfile
        }
    ]
});
