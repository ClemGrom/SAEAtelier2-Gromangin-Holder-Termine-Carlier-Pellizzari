import { createRouter, createWebHistory } from 'vue-router';

import Accueil from './views/Accueil.vue';
import Inscription from './views/Inscription.vue';
import Connexion from './views/Connexion.vue';
import page404 from './views/page404.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Accueil',
            component: Accueil,
        },
        {
            path: '/register',
            name: 'Inscription',
            component: Inscription,
        },
        {
            path: '/login',
            name: 'Connexion',
            component: Connexion,
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'page404',
            component: page404,
        },
    ],
});

export default router;
