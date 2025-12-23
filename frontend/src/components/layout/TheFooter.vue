<template>
  <footer class="border-t border-slate-800/60 bg-surface/50">
    <div class="mx-auto max-w-6xl px-6 py-8 text-center">
      <p class="text-sm text-slate-400">
        © {{ currentYear }} {{ name }}. All rights reserved.
      </p>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  name: {
    type: String,
    default: 'Saad Shivan Tech'
  }
});

const currentYear = computed(() => new Date().getFullYear());
</script>

