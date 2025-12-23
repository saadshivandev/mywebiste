<template>
  <section id="about" class="relative mt-24 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute -right-20 top-0 h-96 w-96 rounded-full bg-accent/5 blur-3xl"></div>
    
    <div class="relative">
      <!-- Section Header -->
      <div class="mb-12 text-center">
        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-accent">About Me</p>
        <h2 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">
          Professional Background
        </h2>
        <div class="mx-auto mt-4 h-1 w-16 bg-gradient-to-r from-transparent via-accent to-transparent"></div>
      </div>

      <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
        <!-- Main Content - Left Side -->
        <div>
          <!-- Bio Card -->
          <div class="group relative overflow-hidden rounded-2xl border border-slate-800/60 bg-gradient-to-br from-surface/80 to-surface/40 p-6 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-accent/30 hover:shadow-2xl hover:shadow-accent/5 sm:p-8">
            <div class="absolute inset-0 bg-gradient-to-br from-accent/5 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            
            <div class="relative">
              <div class="mb-5 flex items-center gap-3 sm:mb-6">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-accent/10 sm:h-12 sm:w-12">
                  <svg class="h-5 w-5 text-accent sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="min-w-0 flex-1">
                  <h3 class="text-lg font-bold text-white sm:text-xl">{{ profile?.name || 'Saad Shivan Tech' }}</h3>
                  <p class="text-xs text-accent sm:text-sm">{{ profile?.role || 'Full Stack Developer' }}</p>
                </div>
              </div>

              <div class="space-y-3 text-sm leading-relaxed text-slate-300 sm:space-y-4 sm:text-base">
                <p v-if="profile?.bio" class="text-slate-200">{{ profile.bio }}</p>
                <p v-else class="text-slate-200">
                  I'm a full stack web developer focused on building robust backends with
                  <span class="font-semibold text-accent">Laravel</span> and elegant frontends with
                  <span class="font-semibold text-accent">Vue.js</span>. I love designing systems that are both clean under the hood and delightful to use.
                </p>
              </div>

              <!-- Languages -->
              <div v-if="profile?.languages" class="mt-5 rounded-xl border border-slate-800/50 bg-slate-900/30 p-3 sm:mt-6 sm:p-4">
                <div class="mb-2 flex items-center gap-2">
                  <svg class="h-3.5 w-3.5 text-accent sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                  </svg>
                  <span class="text-xs font-semibold text-white sm:text-sm">Languages</span>
                </div>
                <p class="text-xs text-slate-300 sm:text-sm">{{ profile.languages }}</p>
              </div>
            </div>
          </div>

          <!-- Stats Grid -->
          <div class="mt-5 grid grid-cols-3 gap-3 sm:mt-6 sm:gap-4">
            <div class="group relative overflow-hidden rounded-xl border border-slate-800/60 bg-gradient-to-br from-surface/60 to-surface/30 p-4 text-center transition-all duration-300 hover:border-accent/40 hover:shadow-lg hover:shadow-accent/10 sm:p-5">
              <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
              <div class="relative">
                <div class="mb-2 flex justify-center">
                  <div class="rounded-lg bg-accent/10 p-1.5 sm:p-2">
                    <svg class="h-4 w-4 text-accent sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                  </div>
                </div>
                <div class="text-2xl font-bold text-white sm:text-3xl">{{ projectCount }}+</div>
                <div class="mt-1 text-[10px] font-medium uppercase tracking-wider text-slate-400 sm:text-xs">Projects</div>
              </div>
            </div>

            <div class="group relative overflow-hidden rounded-xl border border-slate-800/60 bg-gradient-to-br from-surface/60 to-surface/30 p-4 text-center transition-all duration-300 hover:border-accent/40 hover:shadow-lg hover:shadow-accent/10 sm:p-5">
              <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
              <div class="relative">
                <div class="mb-2 flex justify-center">
                  <div class="rounded-lg bg-accent/10 p-1.5 sm:p-2">
                    <svg class="h-4 w-4 text-accent sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                  </div>
                </div>
                <div class="text-2xl font-bold text-white sm:text-3xl">{{ skillCount }}+</div>
                <div class="mt-1 text-[10px] font-medium uppercase tracking-wider text-slate-400 sm:text-xs">Technologies</div>
              </div>
            </div>

            <div class="group relative overflow-hidden rounded-xl border border-slate-800/60 bg-gradient-to-br from-surface/60 to-surface/30 p-4 text-center transition-all duration-300 hover:border-accent/40 hover:shadow-lg hover:shadow-accent/10 sm:p-5">
              <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
              <div class="relative">
                <div class="mb-2 flex justify-center">
                  <div class="rounded-lg bg-accent/10 p-1.5 sm:p-2">
                    <svg class="h-4 w-4 text-accent sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </div>
                <div class="text-2xl font-bold text-white sm:text-3xl">3+</div>
                <div class="mt-1 text-[10px] font-medium uppercase tracking-wider text-slate-400 sm:text-xs">Years Exp.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Skills Card - Right Side -->
        <div>
          <div class="sticky top-24 h-fit rounded-2xl border border-slate-800/60 bg-gradient-to-br from-surface/80 to-surface/40 p-5 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-accent/30 hover:shadow-2xl hover:shadow-accent/5 sm:p-6 lg:p-7">
            <div class="mb-5 flex items-center gap-2.5 sm:mb-6 sm:gap-3">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 sm:h-10 sm:w-10">
                <svg class="h-4 w-4 text-accent sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
              </div>
              <div class="min-w-0 flex-1">
                <h3 class="text-base font-bold text-white sm:text-lg">Core Technologies</h3>
                <p class="text-[10px] text-slate-400 sm:text-xs">Expertise & Skills</p>
              </div>
            </div>

            <div v-if="groupedSkills.length" class="space-y-3">
              <div
                v-for="(group, groupIndex) in groupedSkills"
                :key="group.category"
                class="space-y-2"
              >
                <!-- Category Label -->
                <div class="flex items-center gap-2">
                  <span class="text-[10px] font-semibold uppercase tracking-wider text-accent sm:text-xs">
                    {{ group.category }}
                  </span>
                  <div class="h-px flex-1 bg-slate-800/50"></div>
                </div>

                <!-- Skills in Category - Same Line -->
                <div class="flex flex-wrap gap-2">
                  <div
                    v-for="(skill, skillIndex) in group.skills"
                    :key="skill.id"
                    class="group flex items-center gap-2 rounded-lg border border-slate-800/50 bg-slate-900/30 px-2.5 py-1.5 transition-all duration-200 hover:border-accent/30 hover:bg-slate-900/50 hover:shadow-md hover:shadow-accent/5 sm:gap-2.5 sm:px-3 sm:py-2"
                    :style="{ animationDelay: `${(groupIndex * 100) + (skillIndex * 50)}ms` }"
                  >
                    <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-lg bg-accent/10 transition-colors group-hover:bg-accent/20 sm:h-6 sm:w-6">
                      <div class="h-1.5 w-1.5 rounded-full bg-accent"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-200 transition-colors group-hover:text-white sm:text-sm">
                      {{ skill.name }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="rounded-lg border border-slate-800/50 bg-slate-900/30 p-5 text-center sm:p-6">
              <svg class="mx-auto h-7 w-7 text-slate-600 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
              <p class="mt-2 text-xs text-slate-400 sm:text-sm">Skills coming soon</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  profile: {
    type: Object,
    default: null
  },
  skills: {
    type: Array,
    default: () => []
  },
  projectCount: {
    type: Number,
    default: 0
  },
  skillCount: {
    type: Number,
    default: 0
  }
});

// Group skills by category
const groupedSkills = computed(() => {
  if (!props.skills.length) return [];

  // Group skills by category
  const grouped = props.skills.reduce((acc, skill) => {
    const category = skill.category || 'Other';
    if (!acc[category]) {
      acc[category] = [];
    }
    acc[category].push(skill);
    return acc;
  }, {});

  // Convert to array and sort by category name
  const categoryOrder = ['Frontend', 'Backend', 'DevOps', 'AI', 'Other'];
  return Object.entries(grouped)
    .map(([category, skills]) => ({
      category,
      skills: skills.sort((a, b) => a.name.localeCompare(b.name))
    }))
    .sort((a, b) => {
      const aIndex = categoryOrder.indexOf(a.category);
      const bIndex = categoryOrder.indexOf(b.category);
      if (aIndex === -1 && bIndex === -1) return a.category.localeCompare(b.category);
      if (aIndex === -1) return 1;
      if (bIndex === -1) return -1;
      return aIndex - bIndex;
    });
});
</script>

