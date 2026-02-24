<script setup lang="ts">
import { Gamepad2 } from 'lucide-vue-next'
</script>

<template>
  <footer class="border-t border-border/40 bg-background/50 backdrop-blur-sm">
    <div class="container mx-auto px-4 py-8">
      <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        
        <router-link to="/" class="flex items-center gap-2 group">
          <Gamepad2 class="h-5 w-5 text-primary transition-transform group-hover:rotate-12" />
          <span class="text-sm font-medium text-foreground">
            Game<span class="text-primary">Trackr</span>
          </span>
        </router-link>

        <div class="flex items-center gap-6 text-sm text-muted-foreground">
          <router-link to="#" class="hover:text-foreground transition-colors">
            Termos de uso
          </router-link>
          <router-link to="#" class="hover:text-foreground transition-colors">
            Política de privacidade
          </router-link>
        </div>

        <p class="text-xs text-muted-foreground">
          © 2026 GameTrackr. Todos os direitos reservados.
        </p>
      </div>
    </div>
  </footer>
</template>