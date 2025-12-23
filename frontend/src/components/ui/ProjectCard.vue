<template>
  <article
    class="group relative overflow-hidden rounded-2xl bg-surface shadow-card transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
  >
    <!-- Image Slider or Thumbnail -->
    <div class="relative aspect-video overflow-hidden bg-slate-800">
      <ImageSlider
        v-if="projectImages.length > 0"
        :images="projectImages"
        :autoplay="isHovered"
        :interval="3000"
        container-class="h-full w-full"
        image-class="transition-transform duration-500 group-hover:scale-105"
      />
      <div v-else class="flex h-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
        <svg class="h-12 w-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>

      <!-- Overlay with Links -->
      <div
        class="absolute inset-0 flex items-center justify-center gap-3 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
      >
        <a
          v-if="project.github_url"
          :href="project.github_url"
          target="_blank"
          rel="noopener noreferrer"
          class="flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur-sm transition hover:bg-accent hover:text-slate-900"
          aria-label="View on GitHub"
        >
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
          </svg>
        </a>
        <a
          v-if="project.live_url"
          :href="project.live_url"
          target="_blank"
          rel="noopener noreferrer"
          class="flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur-sm transition hover:bg-accent hover:text-slate-900"
          aria-label="View live demo"
        >
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
        </a>
      </div>
    </div>

    <!-- Content -->
    <div class="p-5">
      <h3 class="text-lg font-semibold text-white transition-colors group-hover:text-accent">
        {{ project.title }}
      </h3>
      <p v-if="project.short_description" class="mt-2 text-sm text-slate-300">
        {{ project.short_description }}
      </p>
      <div v-if="project.tech_stack" class="mt-4 flex flex-wrap gap-2">
        <span
          v-for="tech in techArray"
          :key="tech"
          class="rounded-full bg-slate-800/80 px-2.5 py-1 text-xs font-medium text-slate-300"
        >
          {{ tech }}
        </span>
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed, ref } from 'vue';
import ImageSlider from './ImageSlider.vue';

const props = defineProps({
  project: {
    type: Object,
    required: true
  }
});

const isHovered = ref(false);

const projectImages = computed(() => {
  if (props.project.images && Array.isArray(props.project.images)) {
    return props.project.images;
  }
  if (props.project.thumbnail_path) {
    return [props.project.thumbnail_path];
  }
  return [];
});

const techArray = computed(() => {
  if (!props.project.tech_stack) return [];
  return props.project.tech_stack.split(',').map((t) => t.trim()).filter(Boolean);
});
</script>
