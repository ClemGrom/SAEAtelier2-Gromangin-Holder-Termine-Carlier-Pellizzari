import { createRouter, createWebHistory } from 'vue-router'

import page404 from './views/page404.vue'
import Acceuil from './views/Acceuil.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Accueil',
      component: Acceuil,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'page404',
        component: page404
      },
    
  ]
})

export default router
