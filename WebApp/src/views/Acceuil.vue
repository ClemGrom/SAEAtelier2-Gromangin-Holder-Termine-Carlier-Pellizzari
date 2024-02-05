<template>
  <div class="home-container">
    <div class="header">
      <h1 class="main-title">GeoQuizz</h1>
      <div class="user-actions">
        <router-link to="/register" class="cta-button">pas encore inscrit ?</router-link>
        <router-link to="/login" class="cta-button">Se connecter</router-link>
      </div>
    </div>
    <div class="logo-actions">
      <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
      <div class="extra-actions">
        <router-link to="/profile" class="cta-button">consulter mon profil</router-link>
        <router-link to="/create-game" class="cta-button">Créer une partie !</router-link>
      </div>
    </div>
    <div class="game-intro">
      <p class="game-intro-text">
        Bienvenue dans GeoQuizz, le jeu captivant où vous devez placer avec précision des photos sur la carte de votre ville plus rapidement que les autres joueurs. Prêt pour l'aventure ?
      </p>
    </div>
    <div class="game-principles">
      <GamePrinciples />
    </div>
  </div>
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
.home-container {
  text-align: center;
  background-color: #2c3e50;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  color: #ecf0f1;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.main-title {
  font-size: 48px;
  color: #e74c3c;
  margin-bottom: 20px;
  font-weight: bold;
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
  background-color: #3498db;
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
  width: 150px;
  height: 150px;
  margin-bottom: 30px;
}

.game-intro-text {
  font-size: 18px;
  color: #ecf0f1;
}

.game-principles {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

