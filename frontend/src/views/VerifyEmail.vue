<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { Mail, CheckCircle2, XCircle, Loader2, ArrowRight } from 'lucide-vue-next'
import api from '../services/axios'
// import { useToast } from '../composables/useToast'

const route = useRoute()

// O estado da nossa tela: começa sempre a carregar
const status = ref<'loading' | 'success' | 'error'>('loading')
const errorMessage = ref('')

onMounted(async () => {
  // 1. Pegamos os dados do link do e-mail
  const id = route.query.id
  const hash = route.query.hash

  if (!id || !hash) {
    status.value = 'error'
    errorMessage.value = 'Link de verificação inválido ou ausente.'
    return
  }

  // 2. Disparamos para a nossa API do Laravel
  try {
    await api.post('/email/verify', { 
      id: Number(id), 
      hash: String(hash) 
    })
    status.value = 'success'
  } catch (error: any) {
    status.value = 'error'
    errorMessage.value = error.response?.data?.message || 'Ocorreu um erro ao verificar o seu e-mail.'
  }
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-background to-background-gradient flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      
      <div class="glass-card py-10 px-6 sm:px-10 rounded-2xl shadow-xl text-center relative overflow-hidden">
        
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/20 blur-[60px] rounded-full pointer-events-none" />
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-accent/10 blur-[60px] rounded-full pointer-events-none" />

        <div class="relative z-10">
          <div v-if="status === 'loading'" class="space-y-6">
            <div class="relative inline-flex mb-2">
              <div class="absolute inset-0 bg-primary/20 blur-xl rounded-full animate-pulse" />
              <div class="relative bg-card p-4 rounded-2xl border border-border shadow-lg">
                <Loader2 class="w-16 h-16 text-primary animate-spin" />
              </div>
            </div>
            <h2 class="text-2xl font-bold text-foreground">Verificando...</h2>
            <p class="text-muted-foreground">A validar o seu e-mail de forma segura, aguarde um instante.</p>
          </div>

          <div v-else-if="status === 'success'" class="space-y-6">
            <div class="relative inline-flex mb-2">
              <div class="absolute inset-0 bg-success/20 blur-xl rounded-full" />
              <div class="relative bg-card p-5 rounded-2xl border border-border shadow-lg">
                <Mail class="w-16 h-16 text-primary" />
                <div class="absolute -bottom-3 -right-3 bg-background rounded-full p-1 shadow-sm">
                  <CheckCircle2 class="w-10 h-10 text-success bg-background rounded-full" />
                </div>
              </div>
            </div>
            
            <div>
              <h2 class="text-3xl font-bold text-foreground mb-2">E-mail verificado!</h2>
              <p class="text-muted-foreground">Obrigado por confirmar o seu e-mail. A sua conta do GameTrackr está pronta para ser usada.</p>
            </div>
            
            <router-link to="/auth/login" class="mt-8 w-full inline-flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-md shadow-[0_0_15px_rgba(var(--color-primary),0.2)] text-base font-medium text-primary-foreground bg-primary hover:opacity-90 transition-all">
              Acessar minha conta <ArrowRight class="h-4 w-4" />
            </router-link>
          </div>

          <div v-else class="space-y-6">
            <div class="relative inline-flex mb-2">
              <div class="absolute inset-0 bg-destructive/20 blur-xl rounded-full" />
              <div class="relative bg-card p-5 rounded-2xl border border-destructive/30 shadow-lg">
                <XCircle class="w-16 h-16 text-destructive" />
              </div>
            </div>
            
            <div>
              <h2 class="text-2xl font-bold text-foreground mb-2">Ops, algo deu errado.</h2>
              <p class="text-muted-foreground">{{ errorMessage }}</p>
            </div>
            
            <router-link to="/auth/login" class="mt-8 w-full inline-flex justify-center items-center py-3 px-4 border border-border bg-card hover:bg-muted rounded-md text-base font-medium text-foreground transition-all">
              Voltar para o login
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>