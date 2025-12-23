<template>
  <div class="flex min-h-screen items-center justify-center bg-background text-slate-100">
    <!-- Background Effects -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
      <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-accent/5 blur-3xl"></div>
      <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-accent/5 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md rounded-2xl border border-slate-800/50 bg-surface p-8 shadow-2xl">
      <!-- Logo -->
      <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-accent to-teal-400 shadow-lg shadow-accent/30">
          <svg class="h-8 w-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
        <p class="mt-2 text-sm text-slate-400">
          Sign in to manage your portfolio content
        </p>
      </div>

      <form class="space-y-5" @submit.prevent="submit">
        <div>
          <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
              <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <input
              v-model="email"
              type="email"
              class="w-full rounded-xl border border-slate-700 bg-background py-3 pl-12 pr-4 text-sm text-slate-100 outline-none transition-all placeholder:text-slate-500 focus:border-accent focus:ring-2 focus:ring-accent/20"
              placeholder="admin@example.com"
              required
            />
          </div>
        </div>

        <div>
          <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Password</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
              <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              class="w-full rounded-xl border border-slate-700 bg-background py-3 pl-12 pr-12 text-sm text-slate-100 outline-none transition-all placeholder:text-slate-500 focus:border-accent focus:ring-2 focus:ring-accent/20"
              placeholder="••••••••"
              required
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500 hover:text-slate-300"
            >
              <svg v-if="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
              </svg>
            </button>
          </div>
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="group relative mt-6 w-full overflow-hidden rounded-xl bg-accent py-3 text-sm font-semibold text-slate-900 transition-all hover:shadow-lg hover:shadow-accent/30 disabled:cursor-not-allowed disabled:opacity-60"
        >
          <span class="relative z-10 flex items-center justify-center gap-2">
            <svg v-if="loading" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </span>
          <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
        </button>

        <!-- Error Message -->
        <div v-if="error" class="flex items-center gap-2 rounded-lg bg-red-500/10 p-3 text-sm text-red-400">
          <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          {{ error }}
        </div>
      </form>

      <!-- Back to Portfolio Link -->
      <div class="mt-6 text-center">
        <router-link to="/" class="text-sm text-slate-400 transition hover:text-accent">
          ← Back to portfolio
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { apiPost } from '../../api/client';

const router = useRouter();

const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');
const showPassword = ref(false);

async function submit() {
  error.value = '';
  loading.value = true;

  try {
    const res = await apiPost('/auth/login', {
      email: email.value,
      password: password.value,
    });

    window.localStorage.setItem('auth_token', res.token);
    await router.push({ name: 'admin-dashboard' });
  } catch (e) {
    error.value = e.message || 'Invalid credentials. Please try again.';
  } finally {
    loading.value = false;
  }
}
</script>
