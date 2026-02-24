import { createRouter, createWebHistory } from 'vue-router'
import api from '../services/axios'

import NotFound from '../views/NotFound.vue'
import LoginView from '../views/Login.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Landing',
      component: () => import('../views/Landing.vue'),
      meta: { 
        title: 'GameTrackr | Organize sua vida gamer',
        hideThemeToggle: true,
        hideFooter: true
      }
    },
    {
      path: '/auth/login',
      name: 'login',
      component: LoginView,
      meta: { requiresAuth: false, title: 'Login' }
    }, 
    {
      path: '/auth/register',
      name: 'register',
      component: () => import('../views/Register.vue'),
      meta: { requiresAuth: false, title: 'Registrar' }
    },
    {
      path: '/auth/forgot-password',
      name: 'forgot-password',
      component: () => import('../views/ForgotPassword.vue'),
      meta: { requiresAuth: false, title: 'Recuperar Senha' }
    },
    {
      path: '/logout',
      name: 'logout',
      component: LoginView,
      beforeEnter: async (to, from, next) => {
        try {
          await api.post('/logout')
        } catch (error) {
          console.log('Erro ao tentar deslogar:', error)
        } finally {
          localStorage.removeItem('token')
          sessionStorage.removeItem('token')

          next({ name: 'login' })
        }
      }
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound,
      meta: { title: 'Página Não Encontrada', hideThemeToggle: true }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/Dashboard.vue'),
      // Esta tag avisa que a rota precisa de login
      meta: { requiresAuth: true, title: 'Dashboard' } 
    },
  ]
})

// O "Guardião" (Global Navigation Guard)
router.beforeEach((to, from, next) => {
  const pageTitle = to.meta.title as string
  document.title = pageTitle ? `${pageTitle} | GameTrackr` : 'GameTrackr'

  const isAuthenticated = localStorage.getItem('token') || sessionStorage.getItem('token')
  if (to.meta.requiresAuth && !isAuthenticated) {
    // Se a rota exige login e não há token, manda pro login
    next('/auth/login')
  } else if (to.name === 'login' && isAuthenticated) {
    // Se tentar ir pro login já estando logado, manda pro dashboard
    next('/dashboard')
  } else {
    // Caso contrário, deixa seguir normalmente
    next()
  }
})

export default router