<template>
  <section id="services" class="mt-20 space-y-8">
    <div class="text-center">
      <p class="text-sm font-semibold uppercase tracking-[0.2em] text-accent">Services</p>
      <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">What I do</h2>
      <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">
        I build modern web apps that are fast, responsive, intuitive, and dynamic—crafted with Laravel, Vue, and a clean, maintainable architecture.
      </p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <ServiceCard
        v-for="(service, index) in services"
        :key="service.id"
        :title="service.title"
        :description="service.description"
        :icon="service.icon"
        :style="{ animationDelay: `${index * 0.1}s` }"
        class="fade-in-up"
      />
    </div>
  </section>
</template>

<script setup>
import ServiceCard from '../ui/ServiceCard.vue';

defineProps({
  services: {
    type: Array,
    default: () => []
  }
});
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

