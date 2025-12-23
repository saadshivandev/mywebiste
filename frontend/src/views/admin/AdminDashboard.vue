<template>
  <div class="min-h-screen bg-background text-slate-100">
    <header class="sticky top-0 z-50 border-b border-slate-800/60 bg-surface/90 backdrop-blur">
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <!-- Logo -->
        <div class="flex items-center gap-8">
          <h1 class="text-lg font-semibold text-white">
            <span class="text-accent">Saad</span> Admin
            <span class="ml-2 text-xs font-normal text-slate-400">Portfolio dashboard</span>
          </h1>

          <!-- Navigation Links -->
          <div class="hidden items-center gap-1 md:flex">
            <a
              href="/"
              target="_blank"
              class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-300 transition hover:bg-slate-800/60 hover:text-white"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              View Site
            </a>
            <button
              @click="activeTab = 'profile'"
              class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
              :class="activeTab === 'profile' ? 'bg-accent/10 text-accent' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white'"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profile
            </button>
            <button
              @click="activeTab = 'projects'"
              class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
              :class="activeTab === 'projects' ? 'bg-accent/10 text-accent' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white'"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              Projects
            </button>
            <button
              @click="activeTab = 'contacts'"
              class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
              :class="activeTab === 'contacts' ? 'bg-accent/10 text-accent' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white'"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Messages
              <span v-if="newMessagesCount > 0" class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">
                {{ newMessagesCount }}
              </span>
            </button>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3">
          <button
            class="flex items-center gap-2 rounded-full border border-accent px-4 py-1.5 text-xs font-semibold text-accent transition hover:bg-accent/10"
            @click="logout"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </button>
        </div>
      </nav>
    </header>

    <main class="mx-auto flex max-w-6xl gap-6 px-4 py-8 md:px-6">
      <!-- Sidebar -->
      <aside class="hidden w-56 shrink-0 space-y-2 rounded-2xl border border-slate-800/50 bg-surface p-4 text-sm md:block">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition"
          :class="activeTab === tab.id ? 'bg-accent/10 text-accent' : 'text-slate-300 hover:bg-slate-800/60'"
          @click="activeTab = tab.id"
        >
          <component :is="tab.icon" class="h-4 w-4" />
          <span>{{ tab.label }}</span>
        </button>
      </aside>

      <!-- Mobile Tabs -->
      <div class="mb-4 flex gap-2 overflow-x-auto pb-2 md:hidden">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          class="shrink-0 rounded-full px-4 py-2 text-xs font-medium transition"
          :class="activeTab === tab.id ? 'bg-accent text-slate-900' : 'bg-surface text-slate-300'"
          @click="activeTab = tab.id"
        >
          {{ tab.label }}
        </button>
      </div>

      <section class="flex-1 space-y-6">
        <!-- Profile Tab -->
        <div v-if="activeTab === 'profile'" class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <div class="mb-6 flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-white">Profile</h2>
              <p class="mt-1 text-sm text-slate-400">Edit your hero and about information.</p>
            </div>
          </div>
          <form class="grid gap-5 md:grid-cols-2" @submit.prevent="saveProfile">
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Name</label>
              <input
                v-model="profileForm.name"
                type="text"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Role</label>
              <input
                v-model="profileForm.role"
                type="text"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Headline</label>
              <input
                v-model="profileForm.headline"
                type="text"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Languages</label>
              <input
                v-model="profileForm.languages"
                type="text"
                placeholder="Kurdish (native), Arabic, English, Dutch"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Bio</label>
              <textarea
                v-model="profileForm.bio"
                rows="4"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              ></textarea>
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
              <input
                v-model="profileForm.email"
                type="email"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent focus:ring-1 focus:ring-accent"
              />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Profile Avatar</label>
              <div class="flex flex-col gap-3">
                <!-- Current Avatar Display -->
                <div v-if="profileForm.avatar_path" class="flex items-center gap-3 rounded-xl border border-slate-700 bg-background p-3">
                  <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full border-2 border-slate-700">
                    <img :src="profileForm.avatar_path" alt="Current avatar" class="h-full w-full object-cover" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white">Avatar uploaded</p>
                    <p class="text-xs text-slate-400">Current profile photo</p>
                  </div>
                  <button
                    type="button"
                    @click="deleteAvatar"
                    :disabled="uploadingAvatar"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-red-500/10 hover:text-red-400"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
                <!-- Upload Area -->
                <label
                  class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-700 bg-background p-6 transition hover:border-accent hover:bg-slate-800/50"
                  :class="{ 'opacity-60 pointer-events-none': uploadingAvatar }"
                >
                  <div class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <p class="mt-3 text-sm font-medium text-white">
                    {{ uploadingAvatar ? 'Uploading...' : 'Click to upload avatar' }}
                  </p>
                  <p class="mt-1 text-xs text-slate-400">PNG, JPG, WEBP (max 5MB)</p>
                  <input
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="uploadAvatar"
                    :disabled="uploadingAvatar"
                  />
                </label>
                <p v-if="avatarError" class="text-sm text-red-400">{{ avatarError }}</p>
              </div>
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Resume</label>
              <div class="flex flex-col gap-3">
                <!-- Current Resume Display -->
                <div v-if="profileForm.resume_url" class="flex items-center gap-3 rounded-xl border border-slate-700 bg-background p-3">
                  <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent/10 text-accent">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">Resume uploaded</p>
                    <a :href="profileForm.resume_url" target="_blank" class="text-xs text-accent hover:underline">View current resume</a>
                  </div>
                  <button
                    type="button"
                    @click="deleteResume"
                    :disabled="uploadingResume"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-red-500/10 hover:text-red-400"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
                <!-- Upload Area -->
                <label
                  class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-700 bg-background p-6 transition hover:border-accent hover:bg-slate-800/50"
                  :class="{ 'opacity-60 pointer-events-none': uploadingResume }"
                >
                  <div class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                  </div>
                  <p class="mt-3 text-sm font-medium text-white">
                    {{ uploadingResume ? 'Uploading...' : 'Click to upload resume' }}
                  </p>
                  <p class="mt-1 text-xs text-slate-400">PDF, DOC, DOCX (max 5MB)</p>
                  <input
                    type="file"
                    accept=".pdf,.doc,.docx"
                    class="hidden"
                    @change="uploadResume"
                    :disabled="uploadingResume"
                  />
                </label>
                <p v-if="resumeError" class="text-sm text-red-400">{{ resumeError }}</p>
              </div>
            </div>
            <div class="md:col-span-2">
              <button
                type="submit"
                class="rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-teal-300 disabled:opacity-60"
                :disabled="saving.profile"
              >
                {{ saving.profile ? 'Saving...' : 'Save profile' }}
              </button>
              <span v-if="messages.profile" class="ml-3 text-sm text-accent">{{ messages.profile }}</span>
            </div>
          </form>
        </div>

        <!-- Services Tab -->
        <div v-if="activeTab === 'services'" class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <div class="mb-6 flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-white">Services</h2>
              <p class="mt-1 text-sm text-slate-400">Manage the cards shown in the Services section.</p>
            </div>
            <button
              @click="openServiceModal()"
              class="flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-teal-300"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add Service
            </button>
          </div>
          <div class="space-y-3">
            <div
              v-for="service in services"
              :key="service.id"
              class="flex items-start justify-between rounded-xl border border-slate-700/80 p-4"
            >
              <div class="pr-4">
                <div class="font-semibold text-white">{{ service.title }}</div>
                <div class="mt-1 text-sm text-slate-400">{{ service.description }}</div>
              </div>
              <div class="flex shrink-0 gap-2">
                <button
                  @click="openServiceModal(service)"
                  class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-800 hover:text-white"
                >
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                <button
                  @click="deleteService(service.id)"
                  class="rounded-lg p-2 text-slate-400 transition hover:bg-red-500/10 hover:text-red-400"
                >
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </div>
            <p v-if="!services.length" class="py-8 text-center text-sm text-slate-400">No services yet. Add your first service!</p>
          </div>
        </div>

        <!-- Projects Tab -->
        <div v-if="activeTab === 'projects'" class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <div class="mb-6 flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-white">Projects</h2>
              <p class="mt-1 text-sm text-slate-400">Manage your portfolio projects.</p>
            </div>
            <button
              @click="openProjectModal()"
              class="flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-teal-300"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add Project
            </button>
          </div>
          <div class="grid gap-4 md:grid-cols-2">
            <div
              v-for="project in projects"
              :key="project.id"
              class="rounded-xl border border-slate-700/80 p-4"
            >
              <div class="flex items-start justify-between">
                <div>
                  <div class="font-semibold text-white">{{ project.title }}</div>
                  <span
                    class="mt-1 inline-block rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase"
                    :class="{
                      'bg-blue-500/20 text-blue-300': project.category === 'frontend',
                      'bg-orange-500/20 text-orange-300': project.category === 'backend',
                      'bg-accent/20 text-accent': project.category === 'fullstack' || !project.category,
                    }"
                  >
                    {{ project.category || 'fullstack' }}
                  </span>
                </div>
                <div class="flex shrink-0 gap-2">
                  <button
                    @click="openProjectModal(project)"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-800 hover:text-white"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button
                    @click="deleteProject(project.id)"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-red-500/10 hover:text-red-400"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="mt-2 text-sm text-slate-400">{{ project.short_description }}</div>
              <div v-if="project.tech_stack" class="mt-2 text-xs uppercase tracking-wide text-accent">
                {{ project.tech_stack }}
              </div>
            </div>
          </div>
          <p v-if="!projects.length" class="py-8 text-center text-sm text-slate-400">No projects yet. Add your first project!</p>
        </div>

        <!-- Skills Tab -->
        <div v-if="activeTab === 'skills'" class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <div class="mb-6 flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-white">Skills</h2>
              <p class="mt-1 text-sm text-slate-400">Manage your technology stack.</p>
            </div>
            <button
              @click="openSkillModal()"
              class="flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-teal-300"
            >
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add Skill
            </button>
          </div>
          <div class="flex flex-wrap gap-2">
            <div
              v-for="skill in skills"
              :key="skill.id"
              class="group flex items-center gap-2 rounded-full border border-slate-700 bg-slate-800/50 px-4 py-2 text-sm"
            >
              <span class="text-slate-200">{{ skill.name }}</span>
              <button
                @click="openSkillModal(skill)"
                class="text-slate-500 opacity-0 transition group-hover:opacity-100 hover:text-white"
              >
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </button>
              <button
                @click="deleteSkill(skill.id)"
                class="text-slate-500 opacity-0 transition group-hover:opacity-100 hover:text-red-400"
              >
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          <p v-if="!skills.length" class="py-8 text-center text-sm text-slate-400">No skills yet. Add your first skill!</p>
        </div>

        <!-- Contacts Tab -->
        <div v-if="activeTab === 'contacts'" class="rounded-2xl border border-slate-800/50 bg-surface p-6 shadow-card">
          <div class="mb-6">
            <h2 class="text-lg font-semibold text-white">Contact Messages</h2>
            <p class="mt-1 text-sm text-slate-400">Messages sent from your contact form.</p>
          </div>
          <div class="space-y-4">
            <div
              v-for="message in contacts"
              :key="message.id"
              class="rounded-xl border border-slate-700/80 p-4"
            >
              <div class="flex items-center justify-between">
                <div class="font-semibold text-white">
                  {{ message.name }}
                  <span class="ml-2 text-xs font-normal text-slate-400">{{ message.email }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <span
                    class="rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase"
                    :class="{
                      'bg-emerald-500/20 text-emerald-300': message.status === 'new',
                      'bg-blue-500/20 text-blue-300': message.status === 'read',
                      'bg-slate-700 text-slate-300': message.status === 'archived',
                    }"
                  >
                    {{ message.status }}
                  </span>
                  <select
                    :value="message.status"
                    @change="updateContactStatus(message.id, $event.target.value)"
                    class="rounded-lg border border-slate-700 bg-slate-800 px-2 py-1 text-xs text-slate-300"
                  >
                    <option value="new">New</option>
                    <option value="read">Read</option>
                    <option value="archived">Archived</option>
                  </select>
                </div>
              </div>
              <!-- Service Type Badge -->
              <div class="mt-2">
                <span
                  class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase"
                  :class="{
                    'bg-blue-500/20 text-blue-300': message.service_type === 'frontend',
                    'bg-orange-500/20 text-orange-300': message.service_type === 'backend',
                    'bg-accent/20 text-accent': message.service_type === 'fullstack' || !message.service_type,
                  }"
                >
                  {{ message.service_type || 'fullstack' }} Developer Needed
                </span>
              </div>
              <div class="mt-3 text-sm text-slate-300">{{ message.message }}</div>
              <div class="mt-2 text-xs text-slate-500">{{ formatDate(message.created_at) }}</div>
            </div>
            <p v-if="!contacts.length" class="py-8 text-center text-sm text-slate-400">No messages yet.</p>
          </div>
        </div>
      </section>
    </main>

    <!-- Service Modal -->
    <Teleport to="body">
      <div v-if="showServiceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm" @click.self="showServiceModal = false">
        <div class="w-full max-w-lg rounded-2xl border border-slate-800 bg-surface p-6 shadow-2xl">
          <h3 class="text-lg font-semibold text-white">{{ editingService ? 'Edit Service' : 'Add Service' }}</h3>
          <form class="mt-4 space-y-4" @submit.prevent="saveService">
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Title</label>
              <input
                v-model="serviceForm.title"
                type="text"
                required
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Description</label>
              <textarea
                v-model="serviceForm.description"
                rows="3"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              ></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
              <button type="button" @click="showServiceModal = false" class="rounded-full px-5 py-2 text-sm text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" class="rounded-full bg-accent px-5 py-2 text-sm font-semibold text-slate-900" :disabled="saving.service">
                {{ saving.service ? 'Saving...' : 'Save' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Project Modal -->
    <Teleport to="body">
      <div v-if="showProjectModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/80 p-4 backdrop-blur-sm" @click.self="showProjectModal = false">
        <div class="w-full max-w-2xl rounded-2xl border border-slate-800 bg-surface p-6 shadow-2xl">
          <h3 class="text-lg font-semibold text-white">{{ editingProject ? 'Edit Project' : 'Add Project' }}</h3>
          <form class="mt-4 grid gap-4 md:grid-cols-2" @submit.prevent="saveProject">
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Title</label>
              <input
                v-model="projectForm.title"
                type="text"
                required
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Category</label>
              <select
                v-model="projectForm.category"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              >
                <option value="frontend">Frontend</option>
                <option value="backend">Backend</option>
                <option value="fullstack">Full Stack</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Short Description</label>
              <input
                v-model="projectForm.short_description"
                type="text"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Tech Stack</label>
              <input
                v-model="projectForm.tech_stack"
                type="text"
                placeholder="Vue, Laravel, MySQL"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Thumbnail URL</label>
              <input
                v-model="projectForm.thumbnail_path"
                type="text"
                placeholder="https://..."
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">GitHub URL</label>
              <input
                v-model="projectForm.github_url"
                type="url"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Live URL</label>
              <input
                v-model="projectForm.live_url"
                type="url"
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Project Images</label>
              
              <!-- Debug: Show image count and data -->
              <div class="mb-2 rounded bg-slate-800/50 p-2 text-xs text-slate-400">
                <div>Images count: {{ projectForm.images?.length || 0 }}</div>
                <div>Is array: {{ Array.isArray(projectForm.images) }}</div>
                <div v-if="projectForm.images && projectForm.images.length > 0">First URL: {{ projectForm.images[0] }}</div>
              </div>
              
              <!-- Uploaded Images Display -->
              <div v-if="projectForm.images && Array.isArray(projectForm.images) && projectForm.images.length > 0" class="mb-3 grid grid-cols-3 gap-3">
                <div v-for="(imageUrl, index) in projectForm.images" :key="`img-${index}-${imageUrl}`" class="group relative aspect-video overflow-hidden rounded-lg border border-slate-700">
                  <img :src="imageUrl" :alt="`Project image ${index + 1}`" class="h-full w-full object-cover" @error="console.error('Image failed to load:', imageUrl)">
                  <button
                    type="button"
                    @click="removeProjectImage(index)"
                    class="absolute right-2 top-2 rounded-lg bg-red-500/90 p-1.5 opacity-0 transition group-hover:opacity-100"
                  >
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Upload Area -->
              <div>
                <label
                  for="project-images-input"
                  class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-700 bg-background p-6 transition hover:border-accent hover:bg-slate-800/50"
                  :class="{ 'opacity-60 pointer-events-none': uploadingProjectImages }"
                >
                  <div class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <p class="mt-3 text-sm font-medium text-white">
                    {{ uploadingProjectImages ? 'Uploading...' : 'Click to upload images' }}
                  </p>
                  <p class="mt-1 text-xs text-slate-400">PNG, JPG, WEBP (max 5MB each, up to 10 images)</p>
                </label>
                <input
                  id="project-images-input"
                  type="file"
                  accept="image/*"
                  multiple
                  class="hidden"
                  @change="uploadProjectImages"
                  :disabled="uploadingProjectImages"
                />
              </div>
              <p v-if="projectImageError" class="mt-2 text-sm text-red-400">{{ projectImageError }}</p>
            </div>
            <div class="flex items-center gap-2">
              <input
                type="checkbox"
                v-model="projectForm.is_featured"
                id="is_featured"
                class="h-4 w-4 rounded border-slate-700 bg-background text-accent focus:ring-accent"
              />
              <label for="is_featured" class="text-sm text-slate-300">Featured project</label>
            </div>
            <div class="flex justify-end gap-3 pt-2 md:col-span-2">
              <button type="button" @click="showProjectModal = false" class="rounded-full px-5 py-2 text-sm text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" class="rounded-full bg-accent px-5 py-2 text-sm font-semibold text-slate-900" :disabled="saving.project">
                {{ saving.project ? 'Saving...' : 'Save' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Skill Modal -->
    <Teleport to="body">
      <div v-if="showSkillModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm" @click.self="showSkillModal = false">
        <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-surface p-6 shadow-2xl">
          <h3 class="text-lg font-semibold text-white">{{ editingSkill ? 'Edit Skill' : 'Add Skill' }}</h3>
          <form class="mt-4 space-y-4" @submit.prevent="saveSkill">
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Name</label>
              <input
                v-model="skillForm.name"
                type="text"
                required
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-300">Category</label>
              <input
                v-model="skillForm.category"
                type="text"
                placeholder="Frontend, Backend, Database, etc."
                class="w-full rounded-xl border border-slate-700 bg-background px-4 py-2.5 text-sm text-slate-100 outline-none focus:border-accent"
              />
            </div>
            <div class="flex justify-end gap-3 pt-2">
              <button type="button" @click="showSkillModal = false" class="rounded-full px-5 py-2 text-sm text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" class="rounded-full bg-accent px-5 py-2 text-sm font-semibold text-slate-900" :disabled="saving.skill">
                {{ saving.skill ? 'Saving...' : 'Save' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { computed, h, nextTick, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { apiDelete, apiGet, apiPatch, apiPost, apiPut } from '../../api/client';

const router = useRouter();

// Tab Icons (inline SVG components)
const ProfileIcon = { render: () => h('svg', { class: 'h-4 w-4', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' })]) };
const ServicesIcon = { render: () => h('svg', { class: 'h-4 w-4', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M13 10V3L4 14h7v7l9-11h-7z' })]) };
const ProjectsIcon = { render: () => h('svg', { class: 'h-4 w-4', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' })]) };
const SkillsIcon = { render: () => h('svg', { class: 'h-4 w-4', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z' })]) };
const ContactsIcon = { render: () => h('svg', { class: 'h-4 w-4', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })]) };

const tabs = [
  { id: 'profile', label: 'Profile', icon: ProfileIcon },
  { id: 'services', label: 'Services', icon: ServicesIcon },
  { id: 'projects', label: 'Projects', icon: ProjectsIcon },
  { id: 'skills', label: 'Skills', icon: SkillsIcon },
  { id: 'contacts', label: 'Contact Messages', icon: ContactsIcon },
];

const activeTab = ref('profile');

// Computed
const newMessagesCount = computed(() => {
  return contacts.value.filter(contact => contact.status === 'new').length;
});

// Data
const profileForm = reactive({
  name: '',
  role: '',
  headline: '',
  bio: '',
  languages: '',
  email: '',
  resume_url: '',
  avatar_path: '',
});

const services = ref([]);
const projects = ref([]);
const skills = ref([]);
const contacts = ref([]);

// Modals
const showServiceModal = ref(false);
const showProjectModal = ref(false);
const showSkillModal = ref(false);

const editingService = ref(null);
const editingProject = ref(null);
const editingSkill = ref(null);

const serviceForm = reactive({ title: '', description: '' });
const projectForm = reactive({
  title: '',
  short_description: '',
  tech_stack: '',
  category: 'fullstack',
  github_url: '',
  live_url: '',
  thumbnail_path: '',
  images: [],
  is_featured: false,
});
const skillForm = reactive({ name: '', category: '' });

// State
const saving = reactive({
  profile: false,
  service: false,
  project: false,
  skill: false,
});

const messages = reactive({
  profile: '',
});

// Resume upload state
const uploadingResume = ref(false);
const resumeError = ref('');

// Avatar upload state
const uploadingAvatar = ref(false);
const avatarError = ref('');

// Project image upload state
const uploadingProjectImages = ref(false);
const projectImageError = ref('');

// Load Data
async function loadAll() {
  try {
    const [profileRes, servicesRes, projectsRes, skillsRes, contactsRes] = await Promise.all([
      apiGet('/admin/profile'),
      apiGet('/admin/services'),
      apiGet('/admin/projects'),
      apiGet('/admin/skills'),
      apiGet('/admin/contacts'),
    ]);

    Object.assign(profileForm, {
      name: profileRes?.name || '',
      role: profileRes?.role || '',
      headline: profileRes?.headline || '',
      bio: profileRes?.bio || '',
      languages: profileRes?.languages || '',
      email: profileRes?.email || '',
      resume_url: profileRes?.resume_url || '',
      avatar_path: profileRes?.avatar_path || '',
    });

    services.value = servicesRes || [];
    projects.value = projectsRes || [];
    skills.value = skillsRes || [];
    contacts.value = contactsRes || [];
  } catch (error) {
    console.error('Failed to load admin data', error);
    if (error.message?.includes('401') || error.message?.includes('403')) {
      await router.push({ name: 'admin-login' });
    }
  }
}

// Profile
async function saveProfile() {
  saving.profile = true;
  messages.profile = '';
  try {
    const updated = await apiPut('/admin/profile', profileForm);
    Object.assign(profileForm, updated);
    messages.profile = 'Profile saved successfully!';
  } catch (error) {
    messages.profile = error.message || 'Failed to save profile.';
  } finally {
    saving.profile = false;
  }
}

// Resume Upload
async function uploadResume(event) {
  const file = event.target.files?.[0];
  if (!file) return;

  // Validate file type
  const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
  if (!allowedTypes.includes(file.type)) {
    resumeError.value = 'Please upload a PDF, DOC, or DOCX file.';
    return;
  }

  // Validate file size (5MB)
  if (file.size > 5 * 1024 * 1024) {
    resumeError.value = 'File size must be less than 5MB.';
    return;
  }

  uploadingResume.value = true;
  resumeError.value = '';

  try {
    const formData = new FormData();
    formData.append('resume', file);

    const token = window.localStorage.getItem('auth_token');
    const response = await fetch(`${import.meta.env.VITE_API_URL || 'http://localhost:8000/api'}/admin/profile/resume`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: formData,
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(data.message || 'Failed to upload resume');
    }

    const data = await response.json();
    profileForm.resume_url = data.resume_url;
    messages.profile = 'Resume uploaded successfully!';
  } catch (error) {
    resumeError.value = error.message || 'Failed to upload resume.';
  } finally {
    uploadingResume.value = false;
    event.target.value = ''; // Reset file input
  }
}

async function deleteResume() {
  if (!confirm('Are you sure you want to delete your resume?')) return;

  uploadingResume.value = true;
  resumeError.value = '';

  try {
    await apiDelete('/admin/profile/resume');
    profileForm.resume_url = '';
    messages.profile = 'Resume deleted successfully!';
  } catch (error) {
    resumeError.value = error.message || 'Failed to delete resume.';
  } finally {
    uploadingResume.value = false;
  }
}

// Avatar Upload
async function uploadAvatar(event) {
  const file = event.target.files?.[0];
  if (!file) return;

  // Validate file type
  if (!file.type.startsWith('image/')) {
    avatarError.value = 'Please upload an image file.';
    return;
  }

  // Validate file size (5MB)
  if (file.size > 5 * 1024 * 1024) {
    avatarError.value = 'File size must be less than 5MB.';
    return;
  }

  uploadingAvatar.value = true;
  avatarError.value = '';

  try {
    const formData = new FormData();
    formData.append('avatar', file);

    const token = window.localStorage.getItem('auth_token');
    const response = await fetch(`${import.meta.env.VITE_API_URL || 'http://localhost:8000/api'}/admin/profile/avatar`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: formData,
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(data.message || 'Failed to upload avatar');
    }

    const data = await response.json();
    profileForm.avatar_path = data.avatar_path;
    messages.profile = 'Avatar uploaded successfully!';
    await loadAll(); // Reload to update everywhere
  } catch (error) {
    avatarError.value = error.message || 'Failed to upload avatar.';
  } finally {
    uploadingAvatar.value = false;
    event.target.value = ''; // Reset file input
  }
}

async function deleteAvatar() {
  if (!confirm('Are you sure you want to delete your avatar?')) return;

  uploadingAvatar.value = true;
  avatarError.value = '';

  try {
    await apiDelete('/admin/profile/avatar');
    profileForm.avatar_path = '';
    messages.profile = 'Avatar deleted successfully!';
    await loadAll(); // Reload to update everywhere
  } catch (error) {
    avatarError.value = error.message || 'Failed to delete avatar.';
  } finally {
    uploadingAvatar.value = false;
  }
}

// Services
function openServiceModal(service = null) {
  editingService.value = service;
  if (service) {
    serviceForm.title = service.title;
    serviceForm.description = service.description || '';
  } else {
    serviceForm.title = '';
    serviceForm.description = '';
  }
  showServiceModal.value = true;
}

async function saveService() {
  saving.service = true;
  try {
    if (editingService.value) {
      await apiPut(`/admin/services/${editingService.value.id}`, serviceForm);
    } else {
      await apiPost('/admin/services', serviceForm);
    }
    showServiceModal.value = false;
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to save service');
  } finally {
    saving.service = false;
  }
}

async function deleteService(id) {
  if (!confirm('Are you sure you want to delete this service?')) return;
  try {
    await apiDelete(`/admin/services/${id}`);
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to delete service');
  }
}

// Projects
function openProjectModal(project = null) {
  editingProject.value = project;
  if (project) {
    projectForm.title = project.title;
    projectForm.short_description = project.short_description || '';
    projectForm.tech_stack = project.tech_stack || '';
    projectForm.category = project.category || 'fullstack';
    projectForm.github_url = project.github_url || '';
    projectForm.live_url = project.live_url || '';
    projectForm.thumbnail_path = project.thumbnail_path || '';
    projectForm.images = project.images || [];
    projectForm.is_featured = project.is_featured || false;
  } else {
    projectForm.title = '';
    projectForm.short_description = '';
    projectForm.tech_stack = '';
    projectForm.category = 'fullstack';
    projectForm.github_url = '';
    projectForm.live_url = '';
    projectForm.thumbnail_path = '';
    projectForm.images = [];
    projectForm.is_featured = false;
  }
  showProjectModal.value = true;
}

async function saveProject() {
  saving.project = true;
  try {
    const data = { ...projectForm };
    
    // Ensure images is always an array for database storage
    if (!Array.isArray(data.images)) {
      data.images = data.images ? [data.images] : [];
    }
    
    console.log('Saving project with data:', data);
    
    if (editingProject.value) {
      await apiPut(`/admin/projects/${editingProject.value.id}`, data);
    } else {
      await apiPost('/admin/projects', data);
    }
    showProjectModal.value = false;
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to save project');
  } finally {
    saving.project = false;
  }
}

// Upload project images
async function uploadProjectImages(event) {
  const files = event.target.files;
  if (!files || files.length === 0) return;

  // Validate file count
  if (files.length > 10) {
    projectImageError.value = 'Maximum 10 images allowed';
    return;
  }

  // Validate each file
  for (const file of files) {
    if (!file.type.startsWith('image/')) {
      projectImageError.value = 'Please upload only image files';
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      projectImageError.value = `File "${file.name}" is too large. Maximum size is 5MB`;
      return;
    }
  }

  uploadingProjectImages.value = true;
  projectImageError.value = '';

  try {
    const formData = new FormData();
    // Append files - Laravel expects 'images[]' for array uploads
    Array.from(files).forEach((file) => {
      formData.append('images[]', file);
    });

    const token = window.localStorage.getItem('auth_token');
    if (!token) {
      throw new Error('Not authenticated. Please login again.');
    }

    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';
    const response = await fetch(`${apiUrl}/admin/projects/images`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        // Don't set Content-Type - let browser set it with boundary for FormData
      },
      body: formData,
    });

    if (!response.ok) {
      let errorMessage = 'Failed to upload images';
      try {
        const errorData = await response.json();
        errorMessage = errorData.message || errorData.error || errorMessage;
        if (errorData.errors) {
          const firstError = Object.values(errorData.errors)[0];
          errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
        }
      } catch (e) {
        errorMessage = `Server error: ${response.status} ${response.statusText}`;
      }
      throw new Error(errorMessage);
    }

    const data = await response.json();
    console.log('Upload response:', data);
    if (data.urls && Array.isArray(data.urls)) {
      // Ensure images is always an array and trigger Vue reactivity
      const currentImages = Array.isArray(projectForm.images) ? [...projectForm.images] : [];
      const newImages = [...currentImages, ...data.urls];
      
      // Direct assignment to trigger reactivity
      projectForm.images = newImages;
      
      // Force Vue to update
      await nextTick();
      
      console.log('Current images before:', currentImages);
      console.log('New URLs from server:', data.urls);
      console.log('Updated projectForm.images:', projectForm.images);
      console.log('Is array?', Array.isArray(projectForm.images));
      console.log('Length:', projectForm.images?.length);
      console.log('Full projectForm:', JSON.parse(JSON.stringify(projectForm)));
    } else {
      console.error('Invalid response:', data);
      throw new Error('Invalid response from server');
    }
  } catch (error) {
    projectImageError.value = error.message || 'Failed to upload images';
  } finally {
    uploadingProjectImages.value = false;
    event.target.value = ''; // Reset file input
  }
}

// Remove a project image
function removeProjectImage(index) {
  if (!confirm('Remove this image?')) return;
  projectForm.images.splice(index, 1);
}

async function deleteProject(id) {
  if (!confirm('Are you sure you want to delete this project?')) return;
  
  // Remove project from list immediately (optimistic update)
  const index = projects.value.findIndex(p => p.id === id);
  if (index !== -1) {
    projects.value.splice(index, 1);
  }
  
  try {
    await apiDelete(`/admin/projects/${id}`);
  } catch (error) {
    // If delete failed, reload list to sync with server state
    await loadAll();
    
    // Only show error if it's not a 404 (404 means already deleted, which is fine)
    if (!error.message?.includes('404') && !error.message?.includes('not found')) {
      alert(error.message || 'Failed to delete project');
    }
  }
}

// Skills
function openSkillModal(skill = null) {
  editingSkill.value = skill;
  if (skill) {
    skillForm.name = skill.name;
    skillForm.category = skill.category || '';
  } else {
    skillForm.name = '';
    skillForm.category = '';
  }
  showSkillModal.value = true;
}

async function saveSkill() {
  saving.skill = true;
  try {
    if (editingSkill.value) {
      await apiPut(`/admin/skills/${editingSkill.value.id}`, skillForm);
    } else {
      await apiPost('/admin/skills', skillForm);
    }
    showSkillModal.value = false;
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to save skill');
  } finally {
    saving.skill = false;
  }
}

async function deleteSkill(id) {
  if (!confirm('Are you sure you want to delete this skill?')) return;
  try {
    await apiDelete(`/admin/skills/${id}`);
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to delete skill');
  }
}

// Contacts
async function updateContactStatus(id, status) {
  try {
    await apiPatch(`/admin/contacts/${id}`, { status });
    await loadAll();
  } catch (error) {
    alert(error.message || 'Failed to update status');
  }
}

function formatDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
}

// Auth
async function logout() {
  try {
    await apiPost('/auth/logout', {});
  } catch (e) {
    // ignore
  } finally {
    window.localStorage.removeItem('auth_token');
    await router.push({ name: 'admin-login' });
  }
}

onMounted(async () => {
  const token = window.localStorage.getItem('auth_token');
  if (!token) {
    await router.push({ name: 'admin-login' });
    return;
  }
  await loadAll();
});
</script>
