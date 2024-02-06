import { createRouter, createWebHistory } from "vue-router";

import Acceuil from "./views/Acceuil.vue";
import Inscription from "./views/Inscription.vue";
import Connexion from "./views/Connexion.vue";
import page404 from "./views/page404.vue";
import jeu from "./views/jeu.vue";
import FinRound from "./views/FinRound.vue";
import FinJeu from "./views/FinJeu.vue";
import Profile from "@/views/Profile.vue";

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
      component: jeu,
    },
    { path: "/FinRound", 
    name: "FinRound",
     component: FinRound },
     {
        path:"/FinJeu",
        name:"FinJeu",
        component: FinJeu,
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
