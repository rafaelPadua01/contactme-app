import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';
import Home from '../Pages/Home.vue';
import Login from '../Pages/Auth/Login.vue'
import Dashboard from '../Pages/Auth/Dashboard.vue';
import ProfileClient from '../Pages/Auth/ProfileClient.vue';
import ProfileProf from '../Pages/Auth/ProfileProf.vue';
import SearchService from '../Pages/Auth/SearchService.vue';
import UserProfile from '../Pages/Profile/UserProfile.vue';
import Galery from '../Pages/Profile/Galery.vue';
import AlbumImages from '../Pages/Profile/Galery/AlbumImages.vue';
import CloaksImages from '../Pages/Profile/Galery/CloaksImages.vue';
import Followers from '../Pages/Profile/Followers.vue';
import Chats from '../Pages/Message/Chats.vue';
import Messages from '../Pages/Message/Messages.vue';
import AppointmentBook from '../Pages/AppointmentBook/AppointmentBook.vue';
import DashboardEnt from '../Pages/Enterprise/DashboardEnt.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/profileClient',
        name: 'profileClient',
        component: ProfileClient
    },
    {
        path: '/profileProf',
        name: 'profileProf',
        component: ProfileProf
    },
    {
        path: '/searchService',
        name: 'searchService',
        component: SearchService
    },
    {
        path: '/searchProfile/:id',
        name: 'searchProfile',
        component: UserProfile
    },
    {
        path: '/galery/:id',
        name: 'galery',
        component: Galery
    },
    {
        path: '/galery/selected/:id',
        name: 'galerySelected',
        component: AlbumImages
    },
    {
        path: '/cloaks/:id',
        name: 'cloaks',
        component: CloaksImages
    },
    {
        path: '/followers/:id',
        name: 'followers',
        component: Followers
    },
    {
        path: '/chats/:id',
        name: 'chats',
        component: Chats
    },
    {
        path: '/messages/:id',
        name: 'messages',
        component: Messages
    },
    {
        path: '/appointment_book/:id',
        name: 'appointment',
        component: AppointmentBook
    },
    {
        path: '/dashboardEnt',
        name: 'dashboardEnt',
        component: DashboardEnt
    },
    {
        path: '/app',
        name: 'app',
        component: App
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;