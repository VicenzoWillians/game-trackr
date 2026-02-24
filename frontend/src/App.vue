<script setup lang="ts">
import { useRoute } from 'vue-router'
import ThemeToggle from './components/ThemeToggle.vue'
import Toast from './components/Toast.vue'
import Footer from './components/Footer.vue'

const route = useRoute()
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <main class="flex-grow flex flex-col">
      <router-view></router-view>
    </main>
    
    <Footer v-if="!route.meta.hideFooter" />
  </div>

  <ThemeToggle v-if="!route.meta.hideThemeToggle" />
  <Toast />
</template>