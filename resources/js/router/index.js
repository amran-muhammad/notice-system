
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Teachers from '../pages/Teachers';
import Students from '../pages/Students';
import Profile from '../pages/Profile';
import Notices from '../pages/Notices';
import CommonNotices from '../pages/CommonNotices';
import Events from '../pages/Events';
import Complains from '../pages/Complains';
import ResetPassword from '../pages/ResetPassword';
import Message from '../pages/Message';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'teachers',
        path: '/teachers',
        component: Teachers
    },
    {
        name: 'students',
        path: '/students',
        component: Students
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile
    },
    {
        name: 'notices',
        path: '/notices',
        component: Notices
    },
    {
        name: 'common-notices',
        path: '/common-notices',
        component: CommonNotices
    },
    {
        name: 'events',
        path: '/events',
        component: Events
    },
    {
        name: 'complains',
        path: '/complains',
        component: Complains
    },
    {
        name: 'reset-password',
        path: '/reset-password',
        component: ResetPassword
    },
    {
        name: 'messages',
        path: '/messages',
        component: Message
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
