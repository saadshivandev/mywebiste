<template>
  <div class="min-h-screen bg-background text-slate-100">
    <!-- Animated Background -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
      <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-accent/5 blur-3xl"></div>
      <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-accent/5 blur-3xl"></div>
    </div>

    <!-- Header -->
    <TheHeader 
      :active-section="activeSection"
      :mobile-menu-open="mobileMenuOpen"
      @toggle-mobile-menu="mobileMenuOpen = !mobileMenuOpen"
      @close-mobile-menu="mobileMenuOpen = false"
    />

    <main class="relative mx-auto max-w-6xl px-4 pb-16 pt-10 md:px-6 md:pt-20">
      <!-- Hero Section -->
      <HeroSection :profile="profile" />

      <!-- Services Section -->
      <ServicesSection :services="services" />

      <!-- About Section -->
      <AboutSection 
        :profile="profile"
        :skills="skills"
        :project-count="allProjects.length"
        :skill-count="skills.length"
      />

      <!-- Projects Section -->
      <ProjectsSection
        :projects="paginatedProjects"
        :current-page="currentPage"
        :total-pages="totalPages"
        :loading="isLoadingProjects"
        @page-change="goToPage"
      />

      <!-- Contact Section -->
      <ContactSection
        :profile="profile"
        :is-submitting="isSubmitting"
        :contact-status="contactStatus"
        :contact-error="contactError"
        @submit-contact="submitContact"
      />
    </main>

    <!-- Footer -->
    <TheFooter :name="profile?.name" />
  </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { apiGet, apiPost } from './api/client';

// Layout Components
import TheHeader from './components/layout/TheHeader.vue';
import TheFooter from './components/layout/TheFooter.vue';

// Section Components
import HeroSection from './components/sections/HeroSection.vue';
import ServicesSection from './components/sections/ServicesSection.vue';
import AboutSection from './components/sections/AboutSection.vue';
import ProjectsSection from './components/sections/ProjectsSection.vue';
import ContactSection from './components/sections/ContactSection.vue';

// Data
const profile = ref(null);
const services = ref([]);
const allProjects = ref([]);
const skills = ref([]);

// UI State
const mobileMenuOpen = ref(false);
const activeSection = ref('home');
const currentPage = ref(1);
const projectsPerPage = 6;
const isLoadingProjects = ref(false);

// Contact form state
const isSubmitting = ref(false);
const contactStatus = ref('');
const contactError = ref(false);

// Computed
const totalPages = computed(() => Math.ceil(allProjects.value.length / projectsPerPage));

const paginatedProjects = computed(() => {
  const start = (currentPage.value - 1) * projectsPerPage;
  const end = start + projectsPerPage;
  return allProjects.value.slice(start, end);
});

// Methods
async function loadData() {
  try {
    console.log('Loading data from API...');
    const [profileRes, servicesRes, projectsRes, skillsRes] = await Promise.all([
      apiGet('/profile').catch(err => {
        console.error('Error loading profile:', err);
        return null;
      }),
      apiGet('/services').catch(err => {
        console.error('Error loading services:', err);
        return [];
      }),
      apiGet('/projects').catch(err => {
        console.error('Error loading projects:', err);
        return [];
      }),
      apiGet('/skills').catch(err => {
        console.error('Error loading skills:', err);
        return [];
      })
    ]);

    console.log('API Responses:', { profileRes, servicesRes, projectsRes, skillsRes });

    profile.value = profileRes || null;
    services.value = Array.isArray(servicesRes) ? servicesRes : [];
    allProjects.value = Array.isArray(projectsRes) ? projectsRes : [];
    skills.value = Array.isArray(skillsRes) ? skillsRes : [];

    console.log('Data loaded:', {
      profile: profile.value,
      servicesCount: services.value.length,
      projectsCount: allProjects.value.length,
      skillsCount: skills.value.length
    });
  } catch (error) {
    console.error('Failed to load initial data', error);
    // Set defaults to prevent UI errors
    profile.value = null;
    services.value = [];
    allProjects.value = [];
    skills.value = [];
  }
}

function goToPage(page) {
  currentPage.value = page;
  document.getElementById('projects')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

async function submitContact(formData) {
  contactStatus.value = '';
  contactError.value = false;
  isSubmitting.value = true;

  try {
    await apiPost('/contact', formData);
    contactStatus.value = 'Thanks! Your message has been sent successfully.';
  } catch (error) {
    contactError.value = true;
    contactStatus.value = error.message || 'Something went wrong. Please try again.';
  } finally {
    isSubmitting.value = false;
  }
}

// Intersection Observer for active section
function setupIntersectionObserver() {
  const sections = ['home', 'about', 'services', 'projects', 'contact'];
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          activeSection.value = entry.target.id;
        }
      });
    },
    { threshold: 0.3, rootMargin: '-100px 0px -50% 0px' }
  );

  sections.forEach((id) => {
    const el = document.getElementById(id);
    if (el) observer.observe(el);
  });

  return observer;
}

let observer = null;

onMounted(() => {
  loadData();
  observer = setupIntersectionObserver();
});

onUnmounted(() => {
  observer?.disconnect();
});
</script>

<style>
/* Global Animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

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

.fade-in-up {
  opacity: 0;
  animation: fadeInUp 0.5s ease-out forwards;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}
</style>
