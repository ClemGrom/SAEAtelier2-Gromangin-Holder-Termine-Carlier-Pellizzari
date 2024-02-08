import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import gameService from './services/gameService'

const app = createApp(App)

app.use(router)

// call checkAndRefreshToken from gameService
await gameService.checkAndRefreshToken()

app.mount('#app')