import { createRouter, createWebHistory } from 'vue-router'

import home from '../components/main.vue'
import Login from '../components/auth/login.vue'
import Register from '../components/auth/register.vue'
import ShowAll from '../components/jobs/jobs.vue'
import JobDetails from '../components/jobs/JobDetails.vue'
import Admin from '../components/admin/admin.vue'

const routes = [
  { path: '/login', name: 'login', component: Login, meta: { guestOnly: true, title: 'Login' } },
  { path: '/register', name: 'register', component: Register, meta: { guestOnly: true, title: 'Register' } },
  { path: '/', component: home, meta: { title: "Dashboard" } },
  { path: '/show-all-jobs', component: ShowAll, meta: { requiresAuth: true, title: "Show All" } },
  { path: '/job-details/:id', name: 'job-details', component: JobDetails, meta: { requiresAuth: true, title: "Job-Details" } },
  
  { path: '/admin', name: 'admin', component: Admin, meta: { requiresAuth: true, title: "Admin-Dashboard" } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  
  const token = localStorage.getItem("token");

  if(to.meta.requiresAuth && !token){
    next('/login');
  } else {
    next();
  }
})

export default router
