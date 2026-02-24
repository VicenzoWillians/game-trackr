<script setup lang="ts">
import { ref } from 'vue'
import api from '../services/axios'
import { useRouter } from 'vue-router'
import { Gamepad2, Mail, Lock, LoaderCircle, Eye, EyeOff } from 'lucide-vue-next'
import { useToast } from '../composables/useToast'
const { show: toast } = useToast()

const router = useRouter()

const email = ref('')
const password = ref('')
const remember = ref(false)
const isLoading = ref(false)
const showPassword = ref(false)

const handleLogin = async () => {
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
    console.log(remember.value ? 'salvou' : 'não salvou')
    console.log(localStorage.getItem('token'), sessionStorage.getItem('token'))
    router.push('/dashboard')

  } catch (error: any) {
    if (error.response) {
      if (error.response.status === 401 || error.response.status === 422) {
        toast(
          'Oops! Encontramos um problema.', 
          'Credenciais inválidas. Por favor, verifique os campos e tente novamente.', 
          'error'
        )
      } else if (error.response.status === 429) {
        toast (
          'Oops! Encontramos um problema.',
          error.response.data.message,
          'error'
        )
      }
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
        </form>

        <div class="mt-4 text-center text-sm text-muted-foreground transition-colors duration-300">
          Não tem uma conta? <router-link to="/auth/register" class="text-primary hover:underline font-medium">Cadastre-se</router-link>
        </div>
      </div>
    </div>
  </div>
</template>