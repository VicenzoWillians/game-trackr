<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Moon, SunMedium } from 'lucide-vue-next'

const isDark = ref(false)

const toggleTheme = () => {
  isDark.value = !isDark.value
  
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme')
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
  
  if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  }
})
</script>

<template>
  <div class="fixed top-4 right-4 z-50 group flex items-center justify-center">
    <div class="absolute right-full mr-3 px-2 py-1.5 bg-foreground text-background 
      text-xs font-medium rounded-md opacity-0 invisible group-hover:visible group-hover:opacity-100 
      group-hover:-translate-x-1 transition-all duration-300 whitespace-nowrap shadow-lg">

      Mudar para modo {{ isDark ? 'claro' : 'escuro' }}
      <div class="absolute top-1/2 -mt-1 -right-1 border-t-4 border-b-4 border-l-4 border-transparent 
        border-l-foreground transition-colors duration-300"></div>
    </div>

    <button 
      @click="toggleTheme" 
      class="p-2 rounded-lg shadow-lg bg-muted text-muted-foreground 
        transition-transform transition-colors duration-300
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
        hover:scale-110 hover:bg-accent hover:text-foreground
        disabled:pointer-events-none disabled:opacity-50"
    >
        <component :is="isDark ? SunMedium : Moon" />
    </button>
  </div>
</template>