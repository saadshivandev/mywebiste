<template>
  <div class="relative overflow-hidden rounded-xl bg-slate-900/50" :class="containerClass">
    <!-- Images Container -->
    <div
      class="flex h-full transition-transform duration-500 ease-out"
      :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
    >
      <div
        v-for="(image, index) in images"
        :key="index"
        class="relative h-full w-full flex-shrink-0"
      >
        <img
          :src="image"
          :alt="`Slide ${index + 1}`"
          class="h-full w-full object-cover"
          :class="imageClass"
          @error="handleImageError"
        />
      </div>
    </div>

    <!-- Navigation Arrows -->
    <template v-if="images.length > 1">
      <button
        @click="prevSlide"
        class="absolute left-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-slate-900/70 text-white backdrop-blur-sm transition hover:bg-accent hover:text-slate-900"
        aria-label="Previous image"
      >
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button
        @click="nextSlide"
        class="absolute right-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-slate-900/70 text-white backdrop-blur-sm transition hover:bg-accent hover:text-slate-900"
        aria-label="Next image"
      >
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </template>

    <!-- Dots Indicator -->
    <div v-if="images.length > 1 && showDots" class="absolute bottom-3 left-1/2 flex -translate-x-1/2 gap-2">
      <button
        v-for="(_, index) in images"
        :key="index"
        @click="goToSlide(index)"
        class="h-2 w-2 rounded-full transition-all duration-300"
        :class="index === currentIndex ? 'w-6 bg-accent' : 'bg-white/50 hover:bg-white/80'"
        :aria-label="`Go to slide ${index + 1}`"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  images: {
    type: Array,
    required: true,
    default: () => []
  },
  autoplay: {
    type: Boolean,
    default: false
  },
  interval: {
    type: Number,
    default: 4000
  },
  showDots: {
    type: Boolean,
    default: true
  },
  containerClass: {
    type: String,
    default: 'aspect-video'
  },
  imageClass: {
    type: String,
    default: ''
  }
});

const currentIndex = ref(0);
let autoplayTimer = null;

function nextSlide() {
  currentIndex.value = (currentIndex.value + 1) % props.images.length;
}

function prevSlide() {
  currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length;
}

function goToSlide(index) {
  currentIndex.value = index;
}

function handleImageError(e) {
  // Use a fallback placeholder if image fails to load
  e.target.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="%234b5563"%3E%3Cpath stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /%3E%3C/svg%3E';
}

function startAutoplay() {
  if (props.autoplay && props.images.length > 1) {
    autoplayTimer = setInterval(nextSlide, props.interval);
  }
}

function stopAutoplay() {
  if (autoplayTimer) {
    clearInterval(autoplayTimer);
    autoplayTimer = null;
  }
}

watch(() => props.autoplay, (val) => {
  if (val) {
    startAutoplay();
  } else {
    stopAutoplay();
  }
});

watch(() => props.images, () => {
  currentIndex.value = 0;
});

onMounted(() => {
  if (props.autoplay) {
    startAutoplay();
  }
});

onUnmounted(stopAutoplay);
</script>

