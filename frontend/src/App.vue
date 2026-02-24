<script setup lang="ts">
import ThemeToggle from './components/ThemeToggle.vue'
import Toast from './components/Toast.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
</script>

<template>
  <router-view></router-view>

  <ThemeToggle v-if="!route.meta.hideThemeToggle" />
  <Toast />
</template>