import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import AdminLogin from '../views/admin/AdminLogin.vue';
import AdminDashboard from '../views/admin/AdminDashboard.vue';
import NotFound from '../views/NotFound.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
  },
  {
    path: '/contact',
    name: 'contact',
    component: HomePage,
    meta: { scrollTo: 'contact' }
  },
  {
    path: '/about',
    name: 'about',
    component: HomePage,
    meta: { scrollTo: 'about' }
  },
  {
    path: '/services',
    name: 'services',
    component: HomePage,
    meta: { scrollTo: 'services' }
  },
  {
    path: '/projects',
    name: 'projects',
    component: HomePage,
    meta: { scrollTo: 'projects' }
  },
  {
    path: '/admin/login',
    name: 'admin-login',
    component: AdminLogin,
  },
  {
    path: '/admin',
    name: 'admin-dashboard',
    component: AdminDashboard,
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // If saved position exists (browser back/forward), use it
    if (savedPosition) {
      return savedPosition;
    }
    
    // Only scroll if this is a navigation with scrollTo meta
    if (to.meta.scrollTo) {
      return new Promise((resolve) => {
        setTimeout(() => {
          const sectionId = to.meta.scrollTo;
          const element = document.getElementById(sectionId);
          
          if (element) {
            const headerOffset = 80;
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            
            window.scrollTo({
              top: Math.max(0, offsetPosition),
              behavior: 'smooth'
            });
            
            resolve({ top: offsetPosition });
          } else {
            resolve({ top: 0 });
          }
        }, 100);
      });
    }
    
    // For home route, only scroll to top if explicitly navigating there
    if (to.path === '/' && from.path && from.path !== '/') {
      return { top: 0, behavior: 'smooth' };
    }
    
    // Don't scroll for any other navigation
    return false;
  },
});

export default router;


