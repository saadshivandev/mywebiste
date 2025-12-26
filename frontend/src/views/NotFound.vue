<template>
  <div class="flex min-h-screen items-center justify-center bg-background px-4">
    <div class="text-center">
      <div class="mb-8">
        <h1 class="text-9xl font-bold text-accent">404</h1>
        <h2 class="mt-4 text-3xl font-semibold text-white">Page Not Found</h2>
        <p class="mt-4 text-lg text-slate-400">
          Sorry, the page you're looking for doesn't exist or is not available.
        </p>
      </div>
      
      <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
        <router-link
          to="/"
          class="rounded-full bg-accent px-6 py-3 font-semibold text-slate-900 transition hover:bg-accent/90"
        >
          Go to Home
        </router-link>
        <button
          @click="$router.go(-1)"
          class="rounded-full border border-slate-700 px-6 py-3 font-semibold text-slate-300 transition hover:border-slate-600 hover:bg-slate-800/50"
        >
          Go Back
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

