<template>
  <form class="space-y-5 rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card" @submit.prevent="handleSubmit">
    <div>
      <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-300">Name</label>
      <input
        type="text"
        v-model="form.name"
        placeholder="Your name"
        class="w-full rounded-xl border border-slate-700 bg-background px-4 py-3 text-sm text-slate-100 outline-none transition-all duration-300 placeholder:text-slate-500 focus:border-accent focus:ring-2 focus:ring-accent/20"
        required
      />
    </div>
    <div>
      <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
      <input
        type="email"
        v-model="form.email"
        placeholder="you@example.com"
        class="w-full rounded-xl border border-slate-700 bg-background px-4 py-3 text-sm text-slate-100 outline-none transition-all duration-300 placeholder:text-slate-500 focus:border-accent focus:ring-2 focus:ring-accent/20"
        required
      />
    </div>
    
    <!-- Service Type Selection -->
    <div>
      <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-300">Service Type</label>
      <div class="flex flex-wrap gap-2">
        <button
          v-for="service in serviceTypes"
          :key="service.value"
          type="button"
          @click="form.service_type = service.value"
          class="rounded-full px-4 py-2 text-sm font-medium transition-all duration-300"
          :class="
            form.service_type === service.value
              ? service.activeClass
              : 'border border-slate-700 bg-slate-800/50 text-slate-300 hover:border-slate-600'
          "
        >
          {{ service.label }}
        </button>
      </div>
    </div>
    
    <div>
      <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-300">Message</label>
      <textarea
        rows="5"
        v-model="form.message"
        placeholder="Tell me about your project..."
        class="w-full resize-none rounded-xl border border-slate-700 bg-background px-4 py-3 text-sm text-slate-100 outline-none transition-all duration-300 placeholder:text-slate-500 focus:border-accent focus:ring-2 focus:ring-accent/20"
        required
      ></textarea>
    </div>
    <button
      type="submit"
      :disabled="isSubmitting"
      class="group relative w-full overflow-hidden rounded-xl bg-accent px-6 py-3 text-sm font-semibold text-slate-900 transition-all duration-300 hover:shadow-lg hover:shadow-accent/30 disabled:cursor-not-allowed disabled:opacity-60"
    >
      <span class="relative z-10 flex items-center justify-center gap-2">
        <svg v-if="isSubmitting" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        {{ isSubmitting ? 'Sending...' : 'Send message' }}
      </span>
      <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
    </button>
    
    <!-- Status Messages -->
    <div v-if="status" class="flex items-center gap-2 rounded-lg p-3" :class="error ? 'bg-red-500/10 text-red-400' : 'bg-accent/10 text-accent'">
      <svg v-if="!error" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      {{ status }}
    </div>
  </form>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
  isSubmitting: {
    type: Boolean,
    default: false
  },
  status: {
    type: String,
    default: ''
  },
  error: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['submit']);

const form = reactive({
  name: '',
  email: '',
  message: '',
  service_type: 'fullstack'
});

const serviceTypes = [
  { 
    value: 'frontend', 
    label: 'Frontend',
    activeClass: 'bg-blue-500/20 text-blue-300 border border-blue-500/50'
  },
  { 
    value: 'backend', 
    label: 'Backend',
    activeClass: 'bg-orange-500/20 text-orange-300 border border-orange-500/50'
  },
  { 
    value: 'fullstack', 
    label: 'Full Stack',
    activeClass: 'bg-accent/20 text-accent border border-accent/50'
  }
];

function handleSubmit() {
  emit('submit', { ...form });
}

// Clear form on success
watch(() => props.status, (newStatus) => {
  if (newStatus && !props.error) {
    form.name = '';
    form.email = '';
    form.message = '';
    form.service_type = 'fullstack';
  }
});
</script>
