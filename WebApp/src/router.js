import { createRouter, createWebHistory } from 'vue-router';

import Acceuil from './views/Acceuil.vue';
import Inscription from './views/Inscription.vue';
import Connexion from './views/Connexion.vue';
import page404 from './views/page404.vue';
import FinRound from './views/FinRound.vue';
import FinJeu from './views/FinJeu.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Accueil',
            component: Acceuil,
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
            path: '/finround',
            name: 'FinRound',
            component: FinRound,
        },
        {
            path: '/finjeu',
            name: 'FinJeu',
            component: FinJeu,
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'page404',
            component: page404,
        },
    ],
});

export default router;
