<template>
  <section id="contact" class="mt-24">
    <div class="mb-8 text-center">
      <p class="text-sm font-semibold uppercase tracking-[0.2em] text-accent">Contact</p>
      <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">Let's build something</h2>
      <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">
        Have a project in mind? Let's discuss how I can help bring your ideas to life.
      </p>
    </div>

    <div class="grid gap-8 md:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)]">
      <!-- Contact Form -->
      <ContactForm 
        @submit="$emit('submit-contact', $event)"
        :is-submitting="isSubmitting"
        :status="contactStatus"
        :error="contactError"
      />

      <div class="space-y-6">
        <!-- Contact Info Card -->
        <div class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <h3 class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-accent">Contact Info</h3>
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent/10 text-accent">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-slate-400">Email</p>
                <p class="text-sm font-medium text-white">{{ profile?.email || 'saad@example.com' }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent/10 text-accent">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-slate-400">Location</p>
                <p class="text-sm font-medium text-white">{{ profile?.location || 'Available Worldwide' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Social Links Card -->
        <SocialLinks :profile="profile" />
      </div>
    </div>
  </section>
</template>

<script setup>
import ContactForm from '../ui/ContactForm.vue';
import SocialLinks from '../ui/SocialLinks.vue';

defineProps({
  profile: {
    type: Object,
    default: null
  },
  isSubmitting: {
    type: Boolean,
    default: false
  },
  contactStatus: {
    type: String,
    default: ''
  },
  contactError: {
    type: Boolean,
    default: false
  }
});

defineEmits(['submit-contact']);
</script>

