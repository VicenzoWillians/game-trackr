<script setup lang="ts">
import { ref } from 'vue'
import { Gamepad2, Mail, ArrowLeft, LoaderCircle } from 'lucide-vue-next'
import { useToast } from '../composables/useToast'
import api from '../services/axios'

const { show: toast } = useToast()
const email = ref('')
const isLoading = ref(false)
const emailSent = ref(false) // Controla se mostramos o form ou a mensagem de sucesso

const handleForgotPassword = async () => {
  if (!email.value) return
  isLoading.value = true

  try {
    const response = await api.post('/forgot-password', { email: email.value })
    toast(response.data.title, response.data.message, response.data.status)
    emailSent.value = true

  } catch (error: any) {
    const errors = error.response?.data?.errors
    const firstErrorField = Object.keys(errors)[0]
    const firstErrorMessage = firstErrorField ? errors[firstErrorField][0] : null

    // Por questões de segurança, muitos sistemas não avisam se o e-mail NÃO existe, 
    // mas o Laravel avisa por padrão. Vamos exibir a mensagem que vier da API.
    toast(
      'Oops! Encontramos um problema.',
      firstErrorMessage || error.response?.data?.message,
      'error'
    )
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center transition-colors duration-300 
    bg-gradient-to-b from-gradient-start to-gradient-end">
    <div class="rounded-lg border shadow-sm glass-card border-border/50
      bg-card text-card-foreground transition-colors duration-300
      w-full max-w-md">
      <div class="flex flex-col p-6 text-center space-y-4">
        <div class="flex items-center justify-center gap-2">
          <Gamepad2 class="h-8 w-8 text-primary" /> 
          <span class="font-bold text-3xl text-foreground transition-colors duration-300">
            Game<span class="text-primary">Trackr</span>
          </span>
        </div>

        <div v-if="!emailSent">
          <h3 class="font-semibold tracking-tight text-2xl transition-colors duration-300"> Recupere sua senha </h3>
          <p class="text-sm text-muted-foreground mt-1 transition-colors duration-300"> Digite o e-mail associado à sua conta e enviaremos um link para redefinir a sua senha. </p>
        </div>
      </div>

      <div class="p-6 pt-0" v-if="!emailSent">
        <form class="space-y-4" @submit.prevent="handleForgotPassword">
          <div class="space-y-2">
            <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
              E-mail
            </label>
            <div class="mt-1 relative">
              <Mail class="absolute left-3 top-3 h-4 w-4 text-muted-foreground transition-colors duration-300" />
              <input type="email" id="email" name="email" v-model="email" placeholder="seu@email.com" 
                required :disabled="isLoading" 
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base
                ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground
                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
                disabled:cursor-not-allowed disabled:opacity-50 transition-colors duration-300
                placeholder:text-muted-foreground md:text-sm pl-9" />
            </div>
          </div>

          <button type="submit" :disabled="isLoading" class="inline-flex items-center justify-center gap-2 whitespace-nowrap 
            h-10 px-4 py-2 w-full rounded-md text-sm font-medium ring-offset-background transition-colors duration-300
            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
            disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground 
            hover:bg-primary/90">
            <LoaderCircle v-if="isLoading" class="animate-spin" /> {{ isLoading ? 'Enviando...' : 'Enviar link de recuperação' }}
          </button>
        </form>
      </div>

      <div v-else class="p-6 pt-0 text-center animate-in zoom-in-95 duration-300">
        <div class="mx-auto w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-4">
          <Mail class="w-8 h-8 text-primary" />
        </div>
        <h3 class="text-xl font-bold text-foreground">Verifique a sua caixa de entrada</h3>
        <p class="text-sm text-muted-foreground">
          Enviamos as instruções de recuperação para <strong>{{ email }}</strong>. O link expira em 60 minutos.
        </p>
        <button @click="emailSent = false" class="text-sm text-primary hover:underline mt-2">
          Não recebeu? Tentar novamente
        </button>
      </div>

      <div class="text-center border-t border-border/50 p-6 transition-colors duration-300">
        <router-link to="/auth/login" class="inline-flex items-center gap-2 text-sm font-medium text-muted-foreground 
          hover:text-foreground transition-colors">
          <ArrowLeft class="w-4 h-4" /> Voltar para o login
        </router-link>
      </div>
    </div>
  </div>
</template>