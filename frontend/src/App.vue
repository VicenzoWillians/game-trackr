<script setup lang="ts">
import { ref, onMounted } from 'vue'

// Definimos o formato do nosso dado usando TypeScript
interface Game {
  id: number;
  title: string;
  status: string;
  platform: string;
}

// Variável reativa que vai guardar a lista de jogos
const games = ref<Game[]>([])

// Função que busca os dados no Laravel
const fetchGames = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/games')
    games.value = await response.json()
  } catch (error) {
    console.error("Erro ao buscar jogos:", error)
  }
}

// Assim que a tela carregar, a função é chamada
onMounted(() => {
  fetchGames()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-2xl mx-auto">
      <h1 class="text-3xl font-bold text-slate-800 mb-6">🎮 Game Trackr</h1>
      
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <ul class="divide-y divide-gray-100">
          <li v-for="game in games" :key="game.id" class="p-4 hover:bg-gray-50 transition-colors">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ game.title }}</h2>
                <span class="text-sm text-gray-500">{{ game.platform }}</span>
              </div>
              <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                {{ game.status }}
              </span>
            </div>
          </li>
        </ul>
        
        <div v-if="games.length === 0" class="p-8 text-center text-gray-500">
          Carregando sua biblioteca...
        </div>
      </div>
    </div>
  </div>
</template>