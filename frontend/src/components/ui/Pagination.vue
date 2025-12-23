<template>
  <nav v-if="totalPages > 1" class="flex items-center justify-center gap-2" role="navigation" aria-label="Pagination">
    <!-- Previous Button -->
    <button
      :disabled="currentPage <= 1"
      @click="goToPage(currentPage - 1)"
      class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-surface text-slate-300 transition hover:border-accent hover:text-accent disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-700 disabled:hover:text-slate-300"
      aria-label="Previous page"
    >
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Page Numbers -->
    <div class="flex gap-1">
      <template v-for="page in visiblePages" :key="page">
        <button
          v-if="page !== '...'"
          @click="goToPage(page)"
          class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl px-3 text-sm font-medium transition"
          :class="
            page === currentPage
              ? 'border border-accent bg-accent/10 text-accent'
              : 'border border-slate-700 bg-surface text-slate-300 hover:border-accent hover:text-accent'
          "
          :aria-current="page === currentPage ? 'page' : undefined"
        >
          {{ page }}
        </button>
        <span
          v-else
          class="flex h-10 w-10 items-center justify-center text-slate-500"
        >
          ...
        </span>
      </template>
    </div>

    <!-- Next Button -->
    <button
      :disabled="currentPage >= totalPages"
      @click="goToPage(currentPage + 1)"
      class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-surface text-slate-300 transition hover:border-accent hover:text-accent disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-700 disabled:hover:text-slate-300"
      aria-label="Next page"
    >
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </nav>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  currentPage: {
    type: Number,
    required: true
  },
  totalPages: {
    type: Number,
    required: true
  },
  maxVisible: {
    type: Number,
    default: 5
  }
});

const emit = defineEmits(['update:currentPage']);

const visiblePages = computed(() => {
  const pages = [];
  const total = props.totalPages;
  const current = props.currentPage;
  const max = props.maxVisible;

  if (total <= max) {
    for (let i = 1; i <= total; i++) {
      pages.push(i);
    }
  } else {
    pages.push(1);

    const start = Math.max(2, current - 1);
    const end = Math.min(total - 1, current + 1);

    if (start > 2) {
      pages.push('...');
    }

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    if (end < total - 1) {
      pages.push('...');
    }

    pages.push(total);
  }

  return pages;
});

function goToPage(page) {
  if (page >= 1 && page <= props.totalPages && page !== props.currentPage) {
    emit('update:currentPage', page);
  }
}
</script>

