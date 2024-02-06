<template>
  <body>
  <div class="home-container">
    <nav>
      <div class="header">
        <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
        <h1 class="main-title">GeoQuizz</h1>
      </div>
      <div class="user-actions">
        <router-link to="/register" class="cta-button">Inscris-toi ici !</router-link>
        <router-link to="/login" class="cta-button">Se connecter</router-link>
        <router-link to="/profile" class="profile-link"><img src="@/assets/utilisateur.png" alt="logo utilisateur" class="logo-utilisateur"></router-link>
      </div>
    </nav>
    <div class="game-intro">
      <p>
        Bienvenue sur GeoQuizz ! le jeu captivant où vous devez placer avec précision des photos sur la carte de votre ville plus rapidement que les autres joueurs.
      </p>
      <p1>
        Vous êtes prêt à relever le défi ?
      </p1>
    </div>
    <div class="game-principles">
      <GamePrinciples />
    </div>
    <div class="illustration-section">
      <img src="@/assets/mapNancy.jpeg" alt="Illustration du jeu" class="illustration-image" />
      <router-link to="/create-game" class="cta-button bigger-button">Crées une partie !</router-link>
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
body {
  font-family: Arial, sans-serif;
  background-color: #22364B;
  padding-bottom: 100px;
}

.home-container {
  text-align: center;
  padding: 20px;
  border-radius: 10px;
  color: #ecf0f1;
  display: grid;
  grid-template-columns: 1fr 1fr;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  grid-column: 1/3;
}

.header {
  display: flex;
  align-items: center;
}

.main-title {
  font-size: 48px;
  margin-bottom: 20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  margin-left: 20px;
}

.user-actions {
  display: flex;
  gap: 10px;
}

.cta-button {
  padding: 15px 30px;
  font-size: 20px;
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
  margin-left: 350px;
  width: 100%;
  margin-bottom: 50px;
  text-align: justify;
  margin-top: 20px;
  font-size: 20px;
}

.game-intro p1 {
  font-size: 20px;
  color: red;
  font-weight: bold;
  text-align: justify;
  margin-left: 225px;
}

.game-logo {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}

.game-principles {
  padding: 20px;
  border-radius: 8px;
  background-color: rgba(255, 255, 255, 0.8);
  color: #ecf0f1;
  grid-column: 1/2;
  margin-right: 20px;
}

.illustration-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: white;
  padding: 20px;
  border-radius: 20px;
  grid-column: 2/3;
}

.illustration-image {
  max-width: 100%;
  height: auto;
  margin-bottom: 20px;
}

.bigger-button {
  font-size: 24px;
}
</style>
