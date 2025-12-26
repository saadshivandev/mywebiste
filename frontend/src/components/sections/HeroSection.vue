<template>
  <section
    id="home"
    class="fade-in relative overflow-hidden rounded-3xl bg-gradient-to-br from-surface via-surface to-slate-900/50 px-6 py-12 shadow-card sm:px-10 md:flex md:items-center md:justify-between md:py-16"
  >
    <div class="relative z-10 max-w-xl space-y-5">
      <p class="slide-up text-sm font-medium uppercase tracking-[0.2em] text-accent" style="animation-delay: 0.1s">
        Hi, I'm
      </p>
      <h1 class="slide-up text-3xl font-bold tracking-tight sm:text-4xl md:text-5xl" style="animation-delay: 0.2s">
        {{ profile?.name || 'Saad Shivan Tech' }},<br />
        <span class="bg-gradient-to-r from-accent to-teal-300 bg-clip-text text-transparent">
          {{ profile?.role || 'Full Stack Developer' }}
        </span>
      </h1>
      <p class="slide-up max-w-lg text-sm leading-relaxed text-slate-300 sm:text-base" style="animation-delay: 0.3s">
        {{ profile?.headline || 'A freelance full stack developer specializing in Laravel on the backend and Vue.js on the frontend.' }}
      </p>
      <p class="slide-up text-xs text-slate-400 sm:text-sm" style="animation-delay: 0.4s">
        I enjoy crafting intuitive, responsive, and dynamic experiences that help businesses grow.
      </p>
      <div class="slide-up flex flex-wrap gap-4 pt-2" style="animation-delay: 0.5s">
        <a
          href="/contact"
          class="group relative overflow-hidden rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-slate-900 shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/40"
        >
          <span class="relative z-10">Hire me</span>
          <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
        </a>
        <a
          :href="profile?.resume_url || '#'"
          class="group rounded-full border border-accent px-6 py-2.5 text-sm font-semibold text-accent transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent/10 hover:shadow-lg hover:shadow-accent/10"
        >
          Download Resume
          <svg class="ml-1 inline-block h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </a>
      </div>
    </div>

    <div class="slide-in-right mt-10 flex justify-center md:mt-0 md:w-1/3 md:justify-end" style="animation-delay: 0.3s">
      <div class="relative">
        <div class="absolute -inset-4 rounded-full bg-gradient-to-r from-accent/30 to-teal-400/30 blur-2xl"></div>
        <div class="relative h-40 w-40 overflow-hidden rounded-full border-4 border-accent/70 shadow-2xl shadow-accent/20 sm:h-48 sm:w-48 md:h-56 md:w-56">
          <img
            :src="profile?.avatar_path || '/saad-profile.jpg'"
            alt="Profile photo"
            class="h-full w-full object-cover"
          />
        </div>
      </div>
    </div>

    <div class="pointer-events-none absolute inset-y-0 right-[-10%] hidden opacity-40 mix-blend-screen md:block" aria-hidden="true">
      <div class="h-full w-72 bg-gradient-to-b from-accent/40 via-transparent to-accent/20 blur-3xl"></div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  profile: {
    type: Object,
    default: null
  }
});
</script>

<style scoped>
@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(40px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.fade-in {
  animation: fadeIn 0.6s ease-out forwards;
}

.slide-up {
  opacity: 0;
  animation: slideUp 0.6s ease-out forwards;
}

.slide-in-right {
  opacity: 0;
  animation: slideInRight 0.7s ease-out forwards;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>

