<template>
  <div class="greetings lalezar-regular">
    <img :src="'http://docketu.iutnc.univ-lorraine.fr:50010/assets/' + fondImage" alt="Place Stanislas"
         class="game-image"/>

    <div class="logo">
      <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo"/>
      <h1>GéoQuizz</h1>
    </div>

    <div class="score">
      <h2>Score : {{ totalScore }} Round : {{ currentRound }}/5</h2>
    </div>

    <div class="map-container" @mouseover="expandMap" @mouseleave="shrinkMap">
      <l-map ref="map" class="map" v-model:center="this.center" v-model:zoom="this.defaultZoom" :max-zoom="this.maxZoom"
             :min-zoom="this.minZoom"
             :zoom-control="false" :use-global-leaflet="false" @click="onMapClick">
        <l-tile-layer :url="osmURL"/>
        <l-marker v-if="marker" :lat-lng="marker.coordinates"></l-marker>
      </l-map>
      <router-link :to="{ path: '/FinRound' }" class="custom-button" @click="checkDistance" :disabled="!marker">
        Envoyer
      </router-link>
    </div>

    <div class="timer">
      <button @click="toggleTimer" class="timer-button">
        <img src="@/assets/pause.png" alt="pause" class="pause"/>
      </button>
      <h2>Temps restant : {{ timeRemaining }}</h2>
    </div>

    <div class="indice" v-if="timeRemaining<=30">
      <p>{{ this.indice }}</p>
    </div>

    <div v-if="isPaused" class="modal">
      <div class="modal-content">
        <h2>Jeu en pause</h2>
        <button @click="toggleTimer">Reprendre</button>
        <router-link :to="{ path: '/' }">
          <button class="quitter">Quitter</button>
        </router-link>

      </div>
    </div>
  </div>
</template>

<script>
// Import des feuilles de style et des composants Leaflet nécessaires
import 'leaflet/dist/leaflet.css';
import {LMap, LMarker, LTileLayer} from '@vue-leaflet/vue-leaflet';

export default {
  name: 'jeu',
  components: {
    LMap,
    LTileLayer,
    LMarker
  },
  data() {
    return {
      // URL du serveur de tuiles OpenStreetMap
      osmURL: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      // Centre de la carte initialisé à (0, 0)
      center: [0, 0],
      // Zoom par défaut de la carte
      defaultZoom: 1,
      // Niveau de zoom maximum de la carte
      maxZoom: 18,
      // Niveau de zoom minimum de la carte
      minZoom: 1,
      // Marqueur sur la carte
      marker: null,
      // Temps restant en secondes
      timeRemaining: 60,
      // Intervalle du minuteur
      timerInterval: null,
      // Score de la partie actuelle
      score: 0,
      // Indicateur de pause du minuteur
      isPaused: false,
      // Score total accumulé
      totalScore: 0,
      // Indicateur de l'expansion de la carte
      isMapExpanded: false,
      // Coordonnées de l'image à trouver
      imageCoordinates: [48.6936219, 6.1806664],
      // Numéro du tour actuel
      currentRound: 1,
      // Lieux à découvrir
      lieux: [],
      // Fond d'image
      fondImage: null,
      // Index du lieu actuel
      index: 0,
      // Indicateur d'arrêt du minuteur
      stopTimer: false,
      // Indice pour aider le joueur
      indice: null,
    };
  },
  mounted() {
    // Récupération des informations sur la série depuis le stockage local
    const serie = JSON.parse(localStorage.getItem('infosSeries'));
    try {
      // Initialisation du centre et du zoom de la carte avec les données de la série
      this.center = [serie.defaultLong, serie.defaultLat]
      this.defaultZoom = serie.defaultZoom;
      this.maxZoom = serie.maxZoom;
      this.minZoom = serie.minZoom;
    } catch (error) {
      console.error('Les données des séries ne sont pas au format attendu.');
    }
    // Lancement du jeu
    this.game();
    // Affichage de l'indice si le temps restant est inférieur à 30 secondes
    if (this.timeRemaining < 30) {
      document.querySelector('.indice').style.visibility = 'visible';
    }
  },
  methods: {
    // Fonction de démarrage du jeu
    game() {
      // Récupération de l'index actuel depuis le stockage local
      this.index = localStorage.getItem('index');

      // Récupération des informations sur les lieux depuis le stockage local
      const parsedInfosLieux = JSON.parse(localStorage.getItem('infosLieux'));
      try {
        // Initialisation des lieux avec les données récupérées
        this.lieux = parsedInfosLieux.data;
        const currentLieu = this.lieux[this.index];
        this.indice = currentLieu.indice;
        this.imageCoordinates = currentLieu.localisation.coordinates;

        this.fondImage = currentLieu.image;
      } catch (error) {
        console.error('Les données des lieux ne sont pas au format attendu.');
      }

      // Récupération du score total depuis le stockage local ou initialisation à 0
      this.totalScore = parseInt(localStorage.getItem('totalScore')) || 0;
      // Récupération du numéro du tour actuel depuis le stockage local ou initialisation à 1
      this.currentRound = parseInt(localStorage.getItem('currentRound')) || 1;
      // Réinitialisation du minuteur et démarrage du jeu
      this.stopTimer = false;
      this.timeRemaining = 60;
      this.startTimer();
    },

    // Fonction de démarrage du minuteur
    startTimer() {
      if (!this.timerInterval && !this.stopTimer) {
        this.timerInterval = setInterval(() => {
          if (this.timeRemaining === 0 || this.stopTimer) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
            if (this.timeRemaining === 0) {
              // Passage au tour suivant lorsque le temps est écoulé
              this.currentRound++;
              localStorage.setItem('currentRound', this.currentRound);
              this.redirectToFinRound();
            }
          } else if (!this.isPaused) {
            this.timeRemaining--;
          }
        }, 1000);
      }
    },

    // Fonction de pause du minuteur
    pauseTimer() {
      if (this.timerInterval) {
        clearInterval(this.timerInterval);
        this.timerInterval = null;
        this.isPaused = true;
      }
    },

    // Fonction pour activer ou désactiver la pause du minuteur
    toggleTimer() {
      this.isPaused = !this.isPaused;
    },

    // Redirection vers la page de fin de tour
    redirectToFinRound() {
      if (this.currentRound >= 6) {
        // Si tous les tours sont terminés, redirection vers la page de fin de jeu
        this.pauseTimer();
        this.index++;
        this.stopTimer = true;
        localStorage.setItem('index', this.index);
        this.$router.push('/FinJeu');
      } else {
        // Sinon, redirection vers la page de fin de tour
        this.pauseTimer();
        this.stopTimer = true;
        this.index++;
        localStorage.setItem('index', this.index);
        this.$router.push('/FinRound');
      }
    },

    // Vérification de la distance entre le marqueur et l'emplacement de l'image
    checkDistance() {
      if (this.marker) {
        const distance = this.calculateDistance(this.marker.coordinates, this.imageCoordinates);
        this.updateScore(distance);
        this.marker = null;
        this.currentRound++;
        localStorage.setItem('currentRound', this.currentRound);
        this.redirectToFinRound();
      }
    },

    // Calcul de la distance entre deux coordonnées
    calculateDistance(coord1, coord2) {
      return Math.sqrt(Math.pow(coord2[1] - coord1[0], 2) + Math.pow(coord2[0] - coord1[1], 2));
    },

    // Mise à jour du score en fonction de la distance et du temps restant
    updateScore(distance) {
      let baseScore = 0;

      if (distance < 0.001) {
        baseScore = 10;
      } else if (distance < 0.005) {
        baseScore = 8;
      } else if (distance < 0.01) {
        baseScore = 6;
      } else if (distance < 0.02) {
        baseScore = 4;
      } else if (distance < 0.03) {
        baseScore = 2;
      } else if (distance < 0.04) {
        baseScore = 1;
      }


      let timeMultiplier = 1;
      const timeElapsed = 60 - this.timeRemaining;

      if (timeElapsed <= 10) {
        timeMultiplier = 5;
      } else if (timeElapsed <= 20) {
        timeMultiplier = 3;
      } else if (timeElapsed <= 30) {
        timeMultiplier = 2;
      }

      this.score = baseScore * timeMultiplier;

      // Ajout du score au score total et sauvegarde dans le stockage local
      this.totalScore += this.score;
      localStorage.setItem('score', this.score);
      localStorage.setItem('totalScore', this.totalScore);
    },

    // Gestion du clic sur la carte pour placer le marqueur
    onMapClick(event) {
      this.marker = {
        coordinates: [event.latlng.lat, event.latlng.lng]
      };
    },
  },
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

.greetings {
  position: relative;
}

.logo {
  display: flex;
  align-items: center;
  font-size: 2em;
  z-index: 1;
  color: white;
  text-shadow: 2px 2px 4px rgba(92, 83, 214, 0.5);
  position: absolute;
  top: 0;
  left: 0;
  margin-left: 20px;
}

.logo img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  padding-right: 10px;
}

h2 {
  font-size: 40px;
  margin: 0;
  color: white;
}

.score {
  background-color: #2B80B0;
  z-index: 1;
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 20px;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  margin-top: 20px;
}

.indice {
  background-color: #2B80B0;
  z-index: 1;
  color: white;
  position: absolute;
  bottom: 0;
  align-items: center;
  margin-left: 20px;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  margin-bottom: 20px;
  display: flex;
}

.timer {
  background-color: #2B80B0;
  z-index: 1;
  color: white;
  position: absolute;
  bottom: 0;
  left: 0;
  margin-left: 20px;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  margin-bottom: 20px;
  display: flex;
}

.timer button {
  cursor: pointer;
  background: none;
  border: none;
}

.timer-button {
  background-color: transparent;
  height: 40px;
  width: 40px;
}

.timer-button:hover .pause {
  transform: scale(1.1);
}

.pause {
  transition: transform 0.3s ease;
}

.game-image {
  width: 100%;
  height: 100%;
  position: relative;
  z-index: 0;
}

.map-container {
  height: 200px;
  width: 200px;
  /* Taille initiale */
  position: absolute;
  bottom: 0;
  right: 0;
  z-index: 1;
  margin: 10px;
  overflow: hidden;
  /* Pour cacher le dépassement */
  transition: 0.3s ease;
}

.map {
  border-radius: 20px;
}

.map-container:hover {
  width: 400px;
  /* Taille augmentée au survol */
  height: 400px;
}

.custom-button {
  font-size: 1.2em;
  font-weight: bold;
  color: white;
  background-color: #4AC78D;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: width 0.3s ease, height 0.3s ease;
  /* Ajout de la transition de taille */
  position: absolute;
  z-index: 1;
  bottom: 0;
  right: 0;
  margin: 10px;
  width: 90%;
}

.custom-button:hover {
  background-color: #3fa670;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background-color: #2B80B0;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  text-align: center;
}

.modal-content h2 {
  margin-bottom: 10px;
}

.modal-content button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #4AC78D;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: auto;
}

.modal-content button.quitter {
  background-color: #ff0000;
  /* Rouge */
}

.modal-content button:hover {
  background-color: #3fa670;
}

.modal-content button.quitter:hover {
  background-color: #cc0000;
  /* Rouge foncé au survol */
}
</style>
