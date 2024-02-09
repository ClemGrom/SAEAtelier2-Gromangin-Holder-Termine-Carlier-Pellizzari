<template>
  <div id="container" class="lalezar-regular">
    <nav>
      <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
    </nav>

    <div class="gameScore">
      <div class="scoreText"> Score Final : </div>
      <div class="score">{{ totalScore}}</div>
    </div>

    <footer>
      <img src="@/assets/share.svg" alt="Quit" class="share" />
      <router-link :to="{ path: '/creation-jeu' }" class="restart" @click="resetScoreAndRound">Rejouer</router-link>
      <router-link :to="{ path: '/' }">
           <button><img src="@/assets/quit.svg" alt="Quit" class="quit" /></button>
        </router-link>
    </footer>
  </div>
</template>

<script>
// Import du module Axios pour les requêtes HTTP
import axios from 'axios';

export default {
  // Nom du composant
  name: 'FinRound',
  // Données du composant
  data() {
    return {
      // Score du tour actuel récupéré depuis le stockage local ou initialisé à 0
      score: parseInt(localStorage.getItem('score')) || 0,
      // Numéro du tour récupéré depuis le stockage local ou initialisé à 1
      round: parseInt(localStorage.getItem('round')) || 1,
      // Score total récupéré depuis le stockage local ou initialisé à 0
      totalScore: parseInt(localStorage.getItem('totalScore')) || 0,
      // Jeton d'authentification récupéré depuis le stockage local
      token: localStorage.getItem('token'),
      // Identifiant du jeu récupéré depuis le stockage local
      idgame: localStorage.getItem('game_id'),
      // Client Axios pour effectuer des requêtes HTTP
      apiClient: axios.create({
        withCredentials: false
      }),
    };
  },
  // Méthodes du composant
  methods: {
    // Réinitialisation du score et du numéro du tour
    resetScoreAndRound() {
      // Effacement de toutes les données stockées localement
      // Stoquer les tokens
      const token = localStorage.getItem('token');
      const refreshToken = localStorage.getItem('refreshToken');
      localStorage.clear();

      // Restaurer les tokens
      localStorage.setItem('token', token);
      localStorage.setItem('refreshToken', refreshToken);

      // Réinitialisation des données du composant
      this.score = 0;
      this.round = 1;
      this.totalScore = 0;
    },
    // Soumission du score au serveur
    submitScore() {
      console.log('Id du jeu :', this.idgame);
      console.log('Score total :', this.totalScore);
      console.log('Token :', this.token);
      this.apiClient.post(`http://docketu.iutnc.univ-lorraine.fr:50015/api/games/${this.idgame}/submit/`, {
        // Données à envoyer dans la requête

        score: this.totalScore // Score total à envoyer
        },{
        headers: {
          'Authorization': `Bearer` +this.token ||'',
        },
      })
        .then(response => {
          // Traitement de la réponse du serveur en cas de succès
          console.log(response.data); // Affichage des données renvoyées par le serveur
        })
        .catch(error => {
          // Gestion des erreurs en cas d'échec de la requête
          console.error(error); // Affichage de l'erreur dans la console
        });
    }
  },
  // Fonction exécutée lorsque le composant est monté dans le DOM
  mounted() {
    // Appel de la méthode submitScore pour soumettre le score au serveur
    this.submitScore();
  }
};
</script>


<style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Lalezar&display=swap');
  .lalezar-regular {
      font-family: "Lalezar", system-ui;
      font-weight: 400;
  }
  button {
text-decoration: none;
}

  #container {
      background-color: #2c3e50;
      background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('../assets/placestan.jpg'); /*Changer l'image en fonction de la partie*/
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
      height: 95vh;
  }

  .game-logo {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      margin: 20px;
  }

  .gameScore {
      display: flex;
      flex-direction: column;
      align-items: center;
  }

  .scoreText {
      font-size: 96px;
      -webkit-text-stroke: 0.025em #2B80B0;
      color : white;
      text-shadow: 0px 4px 4px black;
      letter-spacing: -2px;
  }

  .score {
      font-size: 128px;
      -webkit-text-stroke: 0.025em #2B80B0;
      color : white;
      text-shadow: 0px 4px 4px black;
      letter-spacing: -2px;
  }

  footer {
      background-color: #49658F;
      position: fixed;
      bottom: 0;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh;
  }

  .restart {
      background-color: #2E9C39;
      border-radius: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
      color: white;
      font-size: 25px;
      width: 200px;
      height: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 20px;
      margin-left: 20px;
      text-decoration: none;
  }

  .share {
      height: 40px;
      margin-right: 20px;
  }

  .quit {
      height: 30px;
      margin-left: 20px;
  }
</style>