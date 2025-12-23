<template>
  <header class="sticky top-0 z-50 border-b border-slate-800/60 bg-surface/80 backdrop-blur-xl">
    <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
      <a href="#home" class="text-lg font-semibold tracking-tight transition-opacity hover:opacity-80">
        <span class="text-accent">Saad Shivan</span>
        <span class="ml-1 text-slate-300">Tech</span>
      </a>
      
      <!-- Desktop Navigation -->
      <div class="hidden items-center gap-6 md:flex">
        <ul class="flex gap-8 text-sm text-slate-300">
          <li v-for="item in navItems" :key="item.id">
            <a 
              :href="`#${item.id}`" 
              class="relative py-2 transition-colors hover:text-accent" 
              :class="{ 
                'text-accent': activeSection === item.id || item.id === 'home',
                'bg-white text-black rounded-full px-4 py-2 font-semibold hover:bg-transparent hover:text-slate-300': item.id === 'contact'
              }"
            >
              {{ item.label }}
              <span 
                v-if="activeSection === item.id" 
                class="absolute bottom-0 left-0 h-0.5 w-full bg-accent"
              ></span>
            </a>
          </li>
        </ul>
        
        <!-- Admin Link (only visible when logged in) -->
        <a
          v-if="isAdminLoggedIn"
          href="/admin"
          class="flex items-center gap-2 rounded-full border border-accent/50 px-4 py-1.5 text-xs font-semibold text-accent transition hover:bg-accent/10"
        >
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          Admin
        </a>
      </div>
      
      <!-- Mobile Menu Button -->
      <button 
        @click="$emit('toggle-mobile-menu')" 
        class="flex items-center justify-center rounded-lg p-2 text-slate-300 hover:bg-slate-800/50 md:hidden"
      >
        <svg v-if="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </nav>
    
    <!-- Mobile Menu -->
    <div v-if="mobileMenuOpen" class="border-t border-slate-800/60 bg-surface/95 backdrop-blur-xl md:hidden">
      <ul class="flex flex-col gap-1 px-4 py-4">
        <li v-for="item in navItems" :key="item.id">
          <a
            :href="`#${item.id}`"
            @click="$emit('close-mobile-menu')"
            class="block rounded-lg px-4 py-3 text-slate-300 transition-colors hover:bg-slate-800/50 hover:text-accent"
            :class="{ 
              'bg-accent/10 text-accent': (activeSection === item.id || item.id === 'home') && item.id !== 'contact',
              'bg-white text-black font-semibold hover:bg-transparent hover:text-slate-300': item.id === 'contact'
            }"
          >
            {{ item.label }}
          </a>
        </li>
        <li v-if="isAdminLoggedIn" class="border-t border-slate-800/60 pt-2">
          <a
            href="/admin"
            @click="$emit('close-mobile-menu')"
            class="flex items-center gap-2 rounded-lg px-4 py-3 text-accent transition-colors hover:bg-accent/10"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Admin Dashboard
          </a>
        </li>
      </ul>
    </div>
  </header>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

defineProps({
  activeSection: {
    type: String,
    default: 'home'
  },
  mobileMenuOpen: {
    type: Boolean,
    default: false
  }
});

defineEmits(['toggle-mobile-menu', 'close-mobile-menu']);

const navItems = [
  { id: 'home', label: 'Home' },
  { id: 'about', label: 'About me' },
  { id: 'services', label: 'Services' },
  { id: 'projects', label: 'Portfolio' },
  { id: 'contact', label: 'Contact me' }
];

// Check if admin is logged in
const isAdminLoggedIn = ref(false);

function checkAuth() {
  const token = window.localStorage.getItem('auth_token');
  isAdminLoggedIn.value = !!token;
}

// Listen for storage changes (login/logout in other tabs)
function handleStorageChange(e) {
  if (e.key === 'auth_token') {
    checkAuth();
  }
}

onMounted(() => {
  checkAuth();
  window.addEventListener('storage', handleStorageChange);
});
</script>

