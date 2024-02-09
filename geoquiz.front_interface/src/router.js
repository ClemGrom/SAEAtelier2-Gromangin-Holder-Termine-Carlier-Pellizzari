import {createRouter, createWebHistory} from "vue-router";

import Acceuil from "./views/Accueil.vue";
import Inscription from "./views/Inscription.vue";
import Connexion from "./views/Connexion.vue";
import page404 from "./views/page404.vue";
import FinRound from "./views/FinRound.vue";
import FinJeu from "./views/FinJeu.vue";
import Profile from "@/views/Profile.vue";
import Jeu from "@/views/Jeu.vue";
import CreationJeu from "@/views/CreationJeu.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Accueil",
            component: Acceuil,
        },
        {
            path: "/register",
            name: "Inscription",
            component: Inscription,
        },
        {
            path: "/login",
            name: "Connexion",
            component: Connexion,
        },
        {
            path: "/jeu",
            name: "Jeu",
            component: Jeu,
        },
        {
            path: "/FinRound",
            name: "FinRound",
            component: FinRound
        },
        {
            path: "/FinJeu",
            name: "FinJeu",
            component: FinJeu,
        },
        {
            path: "/creation-jeu",
            name: "creation-jeu",
            component: CreationJeu,
        },
        {
            path: '/profile',
            name: 'Profile',
            component: Profile,
        },

        {
            path: "/:pathMatch(.*)*",
            name: "page404",
            component: page404,
        },
    ],
});

export default router;
