<template>
    <div id="container" class="lalezar-regular">
      <nav>
        <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
      </nav>
  
      <div class="gameScore">
        <div class="round">Round {{ round }}/5</div>
        <div class="scoreText">Votre score :</div>
        <div class="score">{{ score }}</div>
      </div>
  
      <footer>
        <div class="timer">{{ timer }}</div>
        <router-link :to="{ path: '/jeu' }" class="continue" >Continuer</router-link>
        <img src="@/assets/quit.svg" alt="Quit" class="quit" />
      </footer>
    </div>
  </template>
  
  <script>
  export default {
    name: 'FinRound',
    data() {
      return {
        score: parseInt(localStorage.getItem('score')) || 0,
        round: parseInt(localStorage.getItem('round')) || 1,
        timer: 20 // Initialiser le timer à 20 secondes
      };
    },
    mounted() {
      // Démarrez le compte à rebours
      this.startCountdown();
    },
    methods: {
      startCountdown() {
        // Utilisez setInterval pour mettre à jour le timer chaque seconde
        this.intervalId = setInterval(() => {
          if (this.timer > 0) {
            this.timer--;
          } else {
            // Redirigez vers la page "jeu" lorsque le temps est écoulé
            this.$router.push('/jeu');
            clearInterval(this.intervalId); // Arrêtez le compte à rebours
          }
        }, 1000);
      }
    },
    beforeDestroy() {
      // Assurez-vous d'arrêter le compte à rebours lorsque le composant est détruit
      clearInterval(this.intervalId);
    }
  };
  </script>
  
  <style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Lalezar&display=swap');
    .lalezar-regular {
        font-family: "Lalezar", system-ui;
        font-weight: 400;
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
        justify-content: center;
    }

    .round {
        font-size: 64px;
        -webkit-text-stroke: 0.025em #2B80B0;
        color : white;
        text-shadow: 0px 4px 4px black;
        letter-spacing: -2px;
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

    .continue {
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
    }

    .quit {
        height: 30px;
        margin-left: 20px;
    }
</style>