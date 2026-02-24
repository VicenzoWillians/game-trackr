<script setup lang="ts">
import { useToast } from '../composables/useToast'
import { X } from 'lucide-vue-next'

const { toasts, remove } = useToast()
const typeClasses = (val: string) => {
  const values: Record<string, string> = {
    success: 'success border-success bg-success text-success-foreground',
    error: 'destructive border-destructive bg-destructive text-destructive-foreground',
    info: 'info border-info bg-info text-info-foreground',
    warning: 'warning border-warning bg-warning text-warning-foreground'
  }
  
  return values[val] || ''
}

</script>

<template>
  <div class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 gap-3
    sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]">
    <TransitionGroup name="toast">
      <div v-for="toast in toasts" :key="toast.id" :class="[ typeClasses(toast.type),
        'group pointer-events-auto relative flex w-full justify-between space-x-4 overflow-hidden rounded-md border p-6 pr-8 shadow-lg transition-all']">
      
      <div class="grid gap-1">
        <div class="text-sm font-semibold">{{ toast.title }}</div>
        <div class="text-sm opacity-90">{{ toast.message }}</div>
      </div>

      <button type="button" v-if="toast.closeButton" class="absolute right-2 top-2 rounded-md p-1 text-foreground/50 opacity-0
        transition-opacity group-hover:opacity-100 hover:text-foreground focus:opacity-100 focus:outline-none 
        focus:ring-2 cursor-pointer" @click="remove(toast.id)">
        <X />
      </button>
      </div>
    </TransitionGroup>
  </div>
</template>

<style scoped>
/* Animação suave de entrada e saída */
.toast-enter-active {
  transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.toast-leave-active {
  transition: all 0.3s ease-in;
}

.toast-enter-from {
  opacity: 0;
  transform: translateY(50px);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100px);
}
</style>