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
    <div class="game-intro" v-if="windowWidth > 780">
      <p>
        Bienvenue sur GeoQuizz ! le jeu captivant où vous devez placer avec précision des photos sur la carte de votre ville le plus rapidement possible.
      </p>
      <p1>
        Vous êtes prêt à relever le défi ?
      </p1>
      <router-link to="/create-game" class="cta-button bigger-button mobile-only btn btn-primary">Crée une partie !</router-link>
      <router-link to="/create-game" class="cta-button bigger-button screen-only">Crée une partie !</router-link>
    </div>



    <div v-else>
      <div class="display-3"> Bienvenue sur GeoQuizz ! le jeu captivant où vous devez placer avec précision des photos sur la carte de votre ville le plus rapidement possible.</div>
      <div class="display-4" style="color: red;"> Vous êtes prêt à relever le défi ?</div>
      <router-link to="/create-game" class="cta-button bigger-button mobile-only btn btn-primary">Crée une partie !</router-link>

      <h2>Principe et règles du jeu</h2>

      <ul>
        <li>Une partie consiste en une séquence de 10 photos aléatoires d'une même série, à placer sur la carte de la ville.</li>
        <li>Chaque série regroupe des photos de la même ville et de la même carte.</li>
        <li>Vous gagnez des points en fonction de la précision du placement et de la rapidité de votre réponse.</li>
        <li>L'objectif est d'obtenir le maximum de points au cours d'une partie de 10 photos.</li>
        <li>La partie se termine une fois que toutes les 10 photos ont été positionnées.</li>
      </ul>

      <h2>Calculer ses points</h2>

      <p><strong>Placement des marqueurs</strong></p>

      <ul>
        <li>pour 1 marqueur placée à une distance &lt; D : <span class="point-value">5pts</span></li>
        <li>pour 1 marqueur placée à une distance &lt; 2D : <span class="point-value">3pts</span></li>
        <li>pour 1 marqueur placée à une distance &lt; 3D : <span class="point-value">1pts</span></li>
      </ul>

      <p><strong>Prise en compte de la rapidité</strong></p>

      <ul>
        <li>les points sont multipliés par 4 pour une réponse en moins de 5s</li>
        <li>les points sont multipliés par 2 pour 1 réponse en moins de 10s</li>
        <li>les points ne sont pas acquis pour 1 réponse en plus de 20s</li>
      </ul>
    </div>



    <div class="game-principles">
      <GamePrinciples />
    </div>
    <div class="illustration-section">
      <img src="@/assets/mapNancy.jpeg" alt="Illustration du jeu" class="illustration-image" />
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
  data() {
    return {
      windowWidth: window.innerWidth
    };
  },
  created() {
    window.addEventListener('resize', this.handleResize);
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      this.windowWidth = window.innerWidth;
    }
  }
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
  font-size: 18px;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  grid-column: 1/3;
  font-size: 16px;
  margin-top: -25px;
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
  padding: 10px 30px;
  margin: 15px;
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

.profile-link {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
}

.game-intro {
  width: 100%;
  margin-bottom: 50px;
  margin-left: 40%;
  margin-right: 40%;
}

p{
  font-size: 20px;
  margin-bottom: 40px;
}

p1 {
  font-size: 20px;
  color: red;
  font-weight: bold;
}

.game-logo {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}

.game-principles {
  padding: 20px;
  border-radius: 8px;
  background-color: #f5f5f1;
  grid-column: 1/2;
  margin-right: 20px;
}

.illustration-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.illustration-image {
  max-width: 100%;
  height: 100%;
  object-fit: cover;
}

.bigger-button {
  font-size: 20px;
}
.mobile-only {
  display: none;
}

.showRules {
  background-color: gray;
}



@media (max-width: 1300px) {
  .home-container {
    grid-template-columns: 1fr;
  }

  .game-intro {
    margin-left: auto;
    margin-right: auto;
    width: 80%;
  }

  .illustration-section {
    order: 1;
  }

  .game-principles {
    order: 2; 
  }

  .mobile-only {
    display: block;
  }

  .screen-only {
    display: none;
  }

  .illustration-image{
    display: none;
  }
}

@media (max-width: 780px) {
  .home-container {
    grid-template-columns: 1fr;
  }

  .game-intro {
    margin-left: auto;
    margin-right: auto;
    width: 90%;
  }

  nav {
    flex-direction: column;
    align-items: center;
  }

  .user-actions {
    flex-direction: column;
    gap: 20px;
  }

  .game-principles {
    display: none;
  }
}
</style>
