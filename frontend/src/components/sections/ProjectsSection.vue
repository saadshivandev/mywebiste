<template>
  <section id="projects" class="mt-24">
    <div class="mb-8 text-center">
      <p class="text-sm font-semibold uppercase tracking-[0.2em] text-accent">Portfolio</p>
      <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">My Projects</h2>
      <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">
        Explore my latest work built with Laravel, Vue.js, and other modern technologies.
      </p>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center py-12">
      <div class="h-8 w-8 animate-spin rounded-full border-2 border-accent border-t-transparent"></div>
    </div>
    
    <!-- Projects Grid -->
    <div v-else-if="projects.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <ProjectCard
        v-for="(project, index) in projects"
        :key="project.id"
        :project="project"
        :style="{ animationDelay: `${index * 0.1}s` }"
        class="fade-in-up"
      />
    </div>
    
    <!-- Empty State -->
    <div v-else class="rounded-2xl border border-slate-800 bg-surface p-12 text-center">
      <svg class="mx-auto h-12 w-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
      </svg>
      <p class="mt-4 text-slate-400">No projects yet. Check back soon!</p>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
      <Pagination
        v-if="totalPages > 1"
        :current-page="currentPage"
        :total-pages="totalPages"
        @update:current-page="$emit('page-change', $event)"
      />
    </div>
  </section>
</template>

<script setup>
import ProjectCard from '../ui/ProjectCard.vue';
import Pagination from '../ui/Pagination.vue';

defineProps({
  projects: {
    type: Array,
    default: () => []
  },
  currentPage: {
    type: Number,
    default: 1
  },
  totalPages: {
    type: Number,
    default: 1
  },
  loading: {
    type: Boolean,
    default: false
  }
});

defineEmits(['page-change']);
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-up {
  opacity: 0;
  animation: fadeInUp 0.5s ease-out forwards;
}
</style>
