<script setup lang="ts">
import { useRouter } from 'vue-router'
import { ArrowLeft } from 'lucide-vue-next'

const router = useRouter()

const goBack = () => {
  // Tenta voltar para a página anterior. Se não conseguir, vai pro login/dashboard.
  if (window.history.length > 2) {
    router.back()
  } else {
    router.push('/dashboard')
  }
}
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center p-4 text-center">    
    <h1 class="text-6xl font-bold tracking-tight">404</h1>
    <h2 class="text-2xl font-semibold mt-1 mb-4">
      Página não encontrada
    </h2>
    
    <p class="max-w-md mb-8">
      Oops! Parece que você se perdeu. A página que você está procurando não existe ou foi movida.
    </p>
    
    <button type="button" @click="goBack" class="inline-flex items-center justify-center px-6 py-3 
      border border-transparent rounded-md text-sm font-medium transition-colors duration-300
      bg-primary text-primary-foreground shadow-sm hover:bg-primary/90"
    >
      <ArrowLeft class="w-5 h-5 mr-2" />
      Voltar
    </button>
  </div>



  <div className="flex min-h-screen items-center justify-center bg-muted">
      <div className="text-center">
        <h1 className="mb-4 text-4xl font-bold">404</h1>
        <p className="mb-4 text-xl text-muted-foreground">Oops! Page not found</p>
        <a href="/" className="text-primary underline hover:text-primary/90">
          Return to Home
        </a>
      </div>
    </div>
</template>