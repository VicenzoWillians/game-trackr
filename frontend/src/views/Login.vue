<script setup lang="ts">
import { ref } from 'vue'
import api from '../services/axios'
import { useRouter } from 'vue-router'
import { Gamepad2, Mail, Lock, LoaderCircle, Eye, EyeOff } from 'lucide-vue-next'
import { useToast } from '../composables/useToast'

const router = useRouter()
const { show: toast } = useToast()

const email = ref('')
const password = ref('')
const remember = ref(false)
const isLoading = ref(false)
const isResending = ref(false)
const showPassword = ref(false)
const needsVerification = ref(false)

const handleLogin = async () => {
  needsVerification.value = false
  isLoading.value = true

  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    const token = response.data.access_token
    if (remember.value) {
      localStorage.setItem('token', token)
    } else {
      sessionStorage.setItem('token', token)
    }
    router.push('/dashboard')

  } catch (error: any) {
    if (error.response) {
      needsVerification.value = error.response?.status === 403 && error.response?.data?.needs_verification

      toast(
        error.response.data.title,
        error.response.data.message, 
        error.response.data.status
      )
    } else {
      toast(
        'Oops! Encontramos um problema.', 
        'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente mais tarde.', 
        'error'
      )
    }

  } finally {
    isLoading.value = false
  }
}

const resendEmail = async () => {
  if (!email.value) return
  isResending.value = true

  try {
    const response = await api.post('/email/resend', { email: email.value })
    toast(response.data.title, response.data.message, response.data.status)

  } catch (error: any) {
    toast(error.response.data.title, error.response.data.message, error.response.data.status)
  } finally {
    isResending.value = false
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

        <div>
          <h3 class="font-semibold tracking-tight text-2xl transition-colors duration-300"> Entrar na sua conta </h3>
          <p class="text-sm text-muted-foreground mt-1 transition-colors duration-300"> Acesse sua biblioteca pessoal de jogos </p>
        </div>
      </div>

      <div class="p-6 pt-0">
        <form class="space-y-4" @submit.prevent="handleLogin"> 
          <div class="space-y-2">
            <label for="email" class="text-sm font-medium leading-none 
              peer-disabled:cursor-not-allowed peer-disabled:opacity-70"> 
              Email 
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

          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label for="password" class="text-sm font-medium leading-none 
                peer-disabled:cursor-not-allowed peer-disabled:opacity-70"> 
                Senha 
              </label>
              <router-link to="/auth/forgot-password" class="text-sm text-muted-foreground font-medium 
                transition-colors duration-300"> 
                Esqueceu a senha? 
              </router-link>
            </div>

            <div class="mt-1 relative">
              <Lock class="absolute left-3 top-3 h-4 w-4 text-muted-foreground transition-colors duration-300" />
              <input :type="showPassword ? 'text' : 'password'" id="password" name="password" v-model="password" 
                placeholder="••••••••" minlength="6" required :disabled="isLoading" 
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base
                ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground
                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
                disabled:cursor-not-allowed disabled:opacity-50 transition-colors duration-300
                placeholder:text-muted-foreground md:text-sm pl-9" />

                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex 
                  items-center text-muted-foreground hover:cursor-pointer transition-colors duration-300">
                  <component :is="showPassword ? EyeOff : Eye" class="h-5 w-5" />
                </button>
            </div>
          </div>

          <div class="space-y-1">
            <div class="flex items-center gap-2">
              <input id="remember-me" type="checkbox" v-model="remember" 
                class="h-4 w-4 rounded border-border accent-primary transition-colors duration-300" />

              <label for="remember-me" class="text-sm font-normal text-muted-foreground cursor-pointer 
                peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                Lembre-se de mim
              </label>
            </div>
          </div>

          <button type="submit" :disabled="isLoading" 
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap h-10 px-4 py-2 w-full
            rounded-md text-sm font-medium ring-offset-background transition-colors duration-300
            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
            disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground 
            hover:bg-primary/90">
            <LoaderCircle v-if="isLoading" class="animate-spin" /> Entrar
          </button>

          <div v-if="needsVerification" class="mt-4 p-4 rounded-xl bg-warning/10 border border-warning/20
            text-center animate-in fade-in slide-in-from-top-2">
            <p class="text-sm text-foreground mb-3">
              Não recebeu o link ou o e-mail expirou?
            </p>
            <button type="button" @click="resendEmail" :disabled="isResending" class="w-full inline-flex justify-center 
              items-center gap-2 py-2 px-4 border border-warning/30 rounded-md text-sm font-medium text-warning 
              hover:bg-warning/10 transition-colors disabled:opacity-50">
                <Mail class="h-4 w-4" />
              {{isResending ? 'Reenviando...' : 'Reenviar e-mail agora'}}
            </button>
          </div>
        </form>

        <div class="mt-4 text-center text-sm text-muted-foreground transition-colors duration-300">
          Não tem uma conta? <router-link to="/auth/register" class="text-primary hover:underline font-medium">Cadastre-se</router-link>
        </div>
      </div>
    </div>
  </div>
</template>