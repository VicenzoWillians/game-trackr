<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Gamepad2, Lock, Eye, EyeOff, LoaderCircle } from 'lucide-vue-next'
import { useToast } from '../composables/useToast'
import api from '../services/axios'

const route = useRoute()
const router = useRouter()
const { show: toast } = useToast()

const password = ref('')
const passwordConfirmation = ref('')
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const isLoading = ref(false)

// Variáveis para guardar os dados da URL
const token = ref('')
const email = ref('')

onMounted(() => {
  // Pega os parâmetros que o Laravel mandou no link do e-mail
  token.value = route.query.token as string
  email.value = route.query.email as string

  if (!token.value || !email.value) {
    toast('Oops! Encontramos um problema.', 'Link de recuperação inválido ou incompleto.', 'error')
    router.push('/auth/login')
  }
})

const disableResetPassword = computed(() => {
  if (!password.value || !passwordConfirmation.value) {
    return true
  }

  if (password.value.length < 8 || password.value !== passwordConfirmation.value) {
    return true
  }

  return false
})

const handleResetPassword = async () => {
  if (password.value !== passwordConfirmation.value) {
    toast('Oops! Encontramos um problema.', 'As senhas não coincidem.', 'error')
    return
  }

  isLoading.value = true
  try {
    const response = await api.post('/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value
    })
    
    toast(response.data.title, response.data.message, response.data.status)
    router.push('/auth/login')
    
  } catch (error: any) {
    const errors = error.response?.data?.errors
    const firstErrorField = Object.keys(errors)[0]
    const firstErrorMessage = firstErrorField ? errors[firstErrorField][0] : null

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

        <div>
          <h3 class="font-semibold tracking-tight text-2xl transition-colors duration-300"> Criar nova senha </h3>
          <p class="text-sm text-muted-foreground mt-1 transition-colors duration-300"> Escolha uma senha forte para a sua conta. </p>
        </div>
      </div>

      <div class="p-6 pt-0">
        <form class="space-y-4" @submit.prevent="handleResetPassword">
          <div class="space-y-2">
            <label for="password" class="text-sm font-medium leading-none 
              peer-disabled:cursor-not-allowed peer-disabled:opacity-70"> 
              Nova senha 
            </label>

            <div class="mt-1 relative">
              <Lock class="absolute left-3 top-3 h-4 w-4 text-muted-foreground transition-colors duration-300" />
              <input :type="showPassword ? 'text' : 'password'" id="password" name="password" v-model="password" 
                placeholder="Mínimo de 8 caracteres" minlength="8" required :disabled="isLoading" 
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

          <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium leading-none 
              peer-disabled:cursor-not-allowed peer-disabled:opacity-70"> 
              Confirmar nova senha 
            </label>

            <div class="mt-1 relative">
              <Lock class="absolute left-3 top-3 h-4 w-4 text-muted-foreground transition-colors duration-300" />
              <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" 
                v-model="passwordConfirmation" placeholder="Repita a senha" minlength="8" required :disabled="isLoading" 
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base
                ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground
                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
                disabled:cursor-not-allowed disabled:opacity-50 transition-colors duration-300
                placeholder:text-muted-foreground md:text-sm pl-9" />

              <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex 
                items-center text-muted-foreground hover:cursor-pointer transition-colors duration-300">
                <component :is="showConfirmPassword ? EyeOff : Eye" class="h-5 w-5" />
              </button>
            </div>
          </div>

          <button type="submit" :disabled="isLoading || disableResetPassword" class="inline-flex items-center justify-center gap-2 whitespace-nowrap 
            h-10 px-4 py-2 w-full rounded-md text-sm font-medium ring-offset-background transition-colors duration-300
            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
            disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground 
            hover:bg-primary/90">
            <LoaderCircle v-if="isLoading" class="animate-spin" />
            {{ isLoading ? 'Salvando...' : 'Redefinir senha' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>