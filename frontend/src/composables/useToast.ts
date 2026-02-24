import { ref } from 'vue'

interface ToastMessage {
  id: number;
  title: string;
  message: string;
  type: 'success' | 'error' | 'info' | 'warning';
  closeButton: boolean;
}

const toasts = ref<ToastMessage[]>([])
const MAX_TOASTS = 3

export const useToast = () => {
  const show = (toastTitle: string, toastMessage: string, toastType: 'success' | 'error' | 'info' | 'warning' = 'success') => {
    const id = Date.now()

    toasts.value.push({ id, title: toastTitle, message: toastMessage, type: toastType, closeButton: true })

    if (toasts.value.length > MAX_TOASTS) {
      toasts.value.shift()
    }
    
    setTimeout(() => {
      remove(id)
    }, 5000) // Some após 5 segundos
  }

  const remove = (id: number) => {
    toasts.value = toasts.value.filter(toast => toast.id !== id)
  }

  return { toasts, show, remove }
}