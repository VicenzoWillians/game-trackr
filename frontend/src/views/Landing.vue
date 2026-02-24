<script setup lang="ts">
import { motion } from 'motion-v'
import {
  Gamepad2, Library, BarChart3, Heart, Star, Shield, Zap, Globe,
  ChevronRight, Sparkles, Layers, TrendingUp, Monitor
} from 'lucide-vue-next'
import ThemeToggle from '../components/ThemeToggle.vue'
import Footer from '../components/Footer.vue'

// --- Configurações de Animação (motion-v) ---
const fadeUp = {
  hidden: { opacity: 0, y: 30 },
  visible: (i = 0) => ({
    opacity: 1,
    y: 0,
    transition: { duration: 0.6, delay: i * 0.1, ease: [0, 0, 0.2, 1] }
  })
}

const stagger = {
  visible: { transition: { staggerChildren: 0.12 } }
}

// --- Dados das Seções ---
const features = [
  { icon: Library, title: "Biblioteca Completa", description: "Organize todos os seus jogos em um só lugar com filtros, tags e categorias personalizáveis." },
  { icon: BarChart3, title: "Estatísticas Detalhadas", description: "Acompanhe seu progresso, tempo de jogo e métricas com gráficos interativos." },
  { icon: Heart, title: "Lista de Desejos", description: "Salve jogos que deseja comprar e receba alertas de promoções e lançamentos." },
  { icon: Star, title: "Avaliações Pessoais", description: "Dê notas, escreva reviews e registre suas experiências com cada jogo." },
  { icon: TrendingUp, title: "Dashboard Inteligente", description: "Visão geral da sua coleção com insights e recomendações personalizadas." },
  { icon: Layers, title: "Multi-Plataforma", description: "Gerencie jogos de PC, console e mobile em uma interface unificada." },
]

const differentials = [
  { icon: Zap, title: "Performance", description: "Interface rápida e responsiva com carregamento instantâneo." },
  { icon: Shield, title: "Segurança", description: "Seus dados protegidos com criptografia de ponta a ponta." },
  { icon: Globe, title: "Acesso Global", description: "Disponível em qualquer dispositivo, a qualquer momento." },
  { icon: Sparkles, title: "Design Moderno", description: "Interface elegante com tema escuro e claro." },
]

const mockChartBars = [40, 65, 45, 80, 55, 70, 90, 60, 75, 50, 85, 68]
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-gradient-start to-gradient-end overflow-hidden">
    
    <header class="sticky top-0 z-50 border-b border-border/30 bg-background/80 backdrop-blur-xl">
      <div class="container mx-auto px-4 flex h-16 items-center justify-between">
        <router-link to="/" class="flex items-center gap-2 group">
          <Gamepad2 class="h-6 w-6 text-primary transition-transform group-hover:rotate-12" />
          <span class="font-bold text-xl text-foreground">
            Game<span class="text-primary">Trackr</span>
          </span>
        </router-link>
        
        <div class="flex items-center gap-2">
          <ThemeToggle variant="landing"/>
          <router-link to="/auth/login" class="inline-flex px-4 py-2 text-sm font-medium h-9 rounded-md px-3
            hover:bg-accent hover:text-accent-foreground">
            Entrar
          </router-link>
          <router-link to="/auth/register" class="inline-flex px-4 py-2 text-sm font-medium h-9 rounded-md px-3
            bg-primary text-primary-foreground hover:bg-primary/90">
            Começar agora
          </router-link>
        </div>
      </div>
    </header>

    <section class="relative py-24 md:py-36 overflow-hidden">
      <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-primary/10 blur-[120px] pointer-events-none"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-accent/10 blur-[120px] pointer-events-none"></div>

      <div class="container mx-auto px-4 relative z-10">
        <motion.div class="max-w-3xl mx-auto text-center space-y-6" initial="hidden" animate="visible" :variants="stagger">
          
          <motion.div :variants="fadeUp" :custom="0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
              <Sparkles class="h-3 w-3" />
              Sua coleção de jogos, reinventada
            </span>
          </motion.div>
          
          <motion.h1 :variants="fadeUp" :custom="1" class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight">
            Gerencie sua jornada gamer com <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-accent">estilo e inteligência</span>
          </motion.h1>
          
          <motion.p :variants="fadeUp" :custom="2" class="text-lg md:text-xl text-muted-foreground max-w-2xl mx-auto font-medium">
            Organize, acompanhe e descubra novos jogos. Dashboard inteligente, estatísticas detalhadas e uma experiência visual que todo gamer merece.
          </motion.p>
          
          <motion.div :variants="fadeUp" :custom="3" class="flex flex-col sm:flex-row gap-3 justify-center pt-3">
            <router-link to="/auth/register" class="inline-flex justify-center items-center text-sm font-medium gap-2 px-8 h-11
              rounded-md bg-primary text-primary-foreground hover:bg-primary/90 transition-all 
              shadow-[0_0_20px_rgba(var(--color-primary),0.3)] hover:shadow-[0_0_25px_rgba(var(--color-primary),0.5)]">
              Começar agora <ChevronRight class="h-4 w-4" />
            </router-link>
            <router-link to="/auth/login" class="inline-flex justify-center items-center text-sm font-medium gap-2 px-8 h-11
              rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground transition-all
              backdrop-blur-sm">
              Fazer login
            </router-link>
          </motion.div>

        </motion.div>

        <motion.div initial="{ opacity: 0, y: 60 }" animate="{ opacity: 1, y: 0 }" :transition="{ duration: 0.8, delay: 0.5, ease: 'easeOut' }" 
          class="mt-16 md:mt-24 max-w-4xl mx-auto">
          <div class="relative rounded-xl border border-border/50 bg-card/60 backdrop-blur-sm shadow-2xl shadow-primary/5 overflow-hidden p-1">
            <div class="rounded-lg bg-card p-4 md:p-6 space-y-4">
              
              <div class="flex items-center gap-2 pb-3 border-b border-border/50">
                <div class="flex gap-1.5">
                  <div class="w-3 h-3 rounded-full bg-destructive/60"> </div>
                  <div class="w-3 h-3 rounded-full bg-warning/60"> </div>
                  <div class="w-3 h-3 rounded-full bg-success/60"> </div>
                </div>
                <div class="flex-1 flex justify-center">
                  <div class="px-4 py-1 rounded-md bg-muted/50 text-xs text-muted-foreground font-mono">
                    gametrackr.app/dashboard
                  </div>
                </div>
              </div>

              <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <motion.div v-for="(stat, i) in [
                  { label: 'Total de Jogos', value: '247', icon: Gamepad2 },
                  { label: 'Completados', value: '89', icon: Star },
                  { label: 'Horas Jogadas', value: '1.2k', icon: Monitor },
                  { label: 'Na Wishlist', value: '34', icon: Heart }
                ]" :key="stat.label" initial="{ opacity: 0, scale: 0.9 }" animate="{ opacity: 1, scale: 1 }" 
                  :transition="{ duration: 0.4, delay: 0.8 + (i * 0.1) }" 
                  class="rounded-lg bg-muted/30 border border-border/30 p-3 space-y-1">

                  <component :is="stat.icon" class="h-4 w-4 text-primary" />
                  <p class="text-xl font-bold text-foreground">{{ stat.value }}</p>
                  <p class="text-xs text-muted-foreground">{{ stat.label }}</p>
                </motion.div>
              </div>

              <div class="h-32 md:h-44 rounded-lg bg-muted/20 border border-border/20 flex items-end justify-around px-4 pb-4 gap-2">
                <motion.div v-for="(h, i) in mockChartBars" :key="i" initial="{ height: 0 }" :animate="{ height: h + '%' }" 
                  :transition="{ duration: 0.6, delay: 1 + (i * 0.05), ease: 'easeOut' }" 
                  class="flex-1 rounded-t-sm bg-gradient-to-t from-primary/60 to-primary/20" />
              </div>

            </div>
          </div>
        </motion.div>
      </div>
    </section>

    <section class="py-20 md:py-28 relative">
      <div class="container mx-auto px-4">
        <motion.div class="text-center max-w-2xl mx-auto mb-14" initial="hidden" whileInView="visible" 
          :viewport="{ once: true, margin: '-80px' }" :variants="stagger">
          <motion.h2 :variants="fadeUp" class="text-3xl md:text-4xl font-bold mb-4">
            Tudo que você precisa, <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-accent">em um só lugar</span>
          </motion.h2>
          <motion.p :variants="fadeUp" :custom="1" class="text-muted-foreground text-lg font-medium">
            Ferramentas poderosas para organizar, analisar e desfrutar da sua coleção de jogos.
          </motion.p>
        </motion.div>

        <motion.div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" initial="hidden" whileInView="visible" 
          :viewport="{ once: true, margin: '-60px' }" :variants="stagger">
          <motion.div v-for="f in features" :key="f.title" :variants="fadeUp" class="group rounded-xl border border-border/40 
            bg-card/50 backdrop-blur-sm p-6 space-y-3 transition-all duration-300 hover:border-primary/30 hover:bg-card/80 
            hover:shadow-lg hover:shadow-primary/5 hover:-translate-y-1">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 
              transition-colors">
              <component :is="f.icon" class="h-5 w-5 text-primary" />
            </div>
            <h3 class="font-semibold text-lg text-foreground">{{ f.title }}</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">{{ f.description }}</p>
          </motion.div>
        </motion.div>
      </div>
    </section>

    <section class="py-20 md:py-28 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/[0.02] to-transparent pointer-events-none" />
      <div class="container mx-auto px-4 relative">
        <motion.div class="text-center max-w-2xl mx-auto mb-14" initial="hidden" whileInView="visible" 
          :viewport="{ once: true, margin: '-80px' }" :variants="stagger">
          <motion.h2 :variants="fadeUp" class="text-3xl md:text-4xl font-bold mb-4">
            Por que escolher o <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-accent">GameTrackr</span>?
          </motion.h2>
          <motion.p :variants="fadeUp" :custom="1" class="text-muted-foreground text-lg font-medium">
            Construído para gamers que levam sua coleção a sério.
          </motion.p>
        </motion.div>

        <motion.div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" initial="hidden" whileInView="visible" :viewport="{ once: true, margin: '-60px' }" :variants="stagger">
          <motion.div v-for="d in differentials" :key="d.title" :variants="fadeUp" class="text-center space-y-3 p-6">
            <div class="w-12 h-12 mx-auto rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center">
              <component :is="d.icon" class="h-5 w-5 text-primary" />
            </div>
            <h3 class="font-semibold text-foreground">{{ d.title }}</h3>
            <p class="text-sm text-muted-foreground">{{ d.description }}</p>
          </motion.div>
        </motion.div>
      </div>
    </section>

    <section class="py-20 md:py-28">
      <div class="container mx-auto px-4">
        <motion.div initial="hidden" whileInView="visible" :viewport="{ once: true, margin: '-80px' }" 
          :variants="stagger" class="max-w-2xl mx-auto text-center rounded-2xl border border-primary/20 
          bg-gradient-to-br from-primary/5 via-card/80 to-accent/5 backdrop-blur-sm p-10 md:p-14 space-y-6">
          <motion.h2 :variants="fadeUp" class="text-3xl md:text-4xl font-bold">
            Pronto para organizar sua <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-accent">coleção</span>?
          </motion.h2>
          <motion.p :variants="fadeUp" :custom="1" class="text-muted-foreground text-lg font-medium">
            Crie sua conta gratuitamente e comece a gerenciar seus jogos agora.
          </motion.p>
          <motion.div :variants="fadeUp" :custom="2">
            <router-link to="/auth/register" class="inline-flex justify-center items-center text-sm font-medium gap-2 px-8 h-11 
              rounded-md bg-primary text-primary-foreground hover:bg-primary/90 transition-all 
              shadow-[0_0_20px_rgba(var(--color-primary),0.3)] hover:shadow-[0_0_25px_rgba(var(--color-primary),0.5)]">
              Começar agora <ChevronRight class="h-4 w-4" />
            </router-link>
          </motion.div>
        </motion.div>
      </div>
    </section>

    <Footer> </Footer>
  </div>
</template>