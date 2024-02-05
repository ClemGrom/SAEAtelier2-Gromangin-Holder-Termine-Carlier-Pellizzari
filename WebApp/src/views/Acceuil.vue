<template>
  <body>

  
  <div class="home-container">
    <nav>
      <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
      <h1 class="main-title">GeoQuizz</h1>
      
      <div class="user-actions">
        <router-link to="/register" class="cta-button">Inscription</router-link>
        <router-link to="/login" class="cta-button">Connection</router-link>
        <router-link to="/profile" ><img src="@/assets/utilisateur.png" alt="logo utilisateur" class="logo-utilisateur"></router-link>
      </div>

    </nav>
   
    <div class="game-intro">
      <p class="game-intro-text">
        Bienvenue dans GeoQuizz, le jeu captivant où vous devez placer avec précision des photos sur la carte de votre ville plus rapidement que les autres joueurs. Prêt pour l'aventure ?
      </p>
    </div>
    <div class="extra-actions">
        
        <router-link to="/create-game" class="cta-button">Créer une partie !</router-link>
      </div>
    <div class="game-principles">
      <GamePrinciples />
    </div>
  </div>
</body>
</template>

<script>
import GamePrinciples from '@/components/GamePrinciples.vue';

export default {
  components: {
    GamePrinciples,
  },
};
</script>

<style scoped>
body{
  font-family: Arial, sans-serif;
  background-color: #2c3e50;
}

.home-container {
  text-align: center;
  background-color: #22364B;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  color: #ecf0f1;
}
nav{
  display: inline-block;
}

img{
  width: 20px;
  height: 20px;
}

.logo-utilisateur{
  width: 40px;
  height: 40px;
  
}
.header {
  display: inline-block;
  align-items: center;
  margin :20px;
}

.main-title {
  font-size: 48px;
  
  margin-bottom: 20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.user-actions {
  display: flex;
  gap: 10px;
}

.logo-actions {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.extra-actions {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.cta-button {
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  color: #ecf0f1;
  background-color: #4AC78D;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.3s;
}

.cta-button:hover {
  background-color: #2980b9;
}

.game-intro {
  margin-bottom: 30px;
}

.game-logo {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}

.game-intro-text {
  font-size: 18px;
  color: #ecf0f1;
}

.game-principles {
  
  padding: 20px;
  border-radius: 8px;
  
}
</style>

