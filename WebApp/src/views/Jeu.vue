<template>
    <div class="greetings lalezar-regular">
        <img :src="`@/assets/${backgroundImage}`" alt="Image du Jeu" class="game-image" />

        <div class="logo">
            <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
            <h1>GéoQuizz</h1>
        </div>

        <div class="score">
            <h2>Score : {{ score }} Round : {{ currentRound }}/5</h2>
        </div>

        <div class="map-container" @mouseover="expandMap" @mouseleave="shrinkMap">
            <l-map ref="map" class="map" v-model:center="center" v-model:zoom="zoom" :max-zoom="maxZoom" :min-zoom="minZoom"
                :zoom-control="false" :use-global-leaflet="false" @click="onMapClick">
                <l-tile-layer :url="osmURL" />
                <l-marker v-for="(lieu, index) in lieux" :key="index" :lat-lng="lieu.localisation.coordinates"></l-marker>
            </l-map>
            <router-link :to="{ path: '/FinRound' }" class="custom-button" @click="checkDistance">Envoyer</router-link>
        </div>

        <div class="timer">
            <button @click="toggleTimer" class="timer-button">
                <img src="@/assets/pause.png" alt="pause" class="pause" />
            </button>
            <h2>Temps restant : {{ timeRemaining }}</h2>
        </div>
        <div v-if="isPaused" class="modal">
            <div class="modal-content">
                <h2>Jeu en pause</h2>
                <button @click="toggleTimer">Reprendre</button>
                <router-link :to="{ path: '/' }"><button class="quitter">Quitter</button></router-link>

            </div>
        </div>
    </div>
</template>

<script>
import 'leaflet/dist/leaflet.css';
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';
import axios from 'axios';

export default {
    name: 'jeu',
    components: {
        LMap,
        LTileLayer,
        LMarker
    },
    data() {
        return {
            osmURL: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            center: [48.694, 6.18], // Position de départ de la carte (à modifier)
            zoom: 10, // Niveau de zoom initial de la carte (à modifier si nécessaire)
            maxZoom: 18,
            minZoom: 1,
            markers: [], // Tableau pour stocker les marqueurs
            timeRemaining: 30,
            timerInterval: null,
            score: 0,
            isPaused: false,
            totalScore: 0,
            isMapExpanded: false,
            currentRound: 1,
            lieux: [], // Tableau pour stocker les lieux
            currentLieu: null, // Lieu actuel à deviner
            imageCoordinates: null, // Coordonnées de l'image actuelle à deviner
            backgroundImage: null, // Image de fond actuelle
        };
    },
    methods: {
        async getLieux() {
            try {
                const response = await axios.get('http://docketu.iutnc.univ-lorraine.fr:50010/items/Lieu?filter[id][_in]=1,2,4,5,6');
                this.lieux = response.data.data;
                this.currentLieu = this.lieux[0]; // Prendre le premier lieu
                this.updateImageCoordinates(); // Mettre à jour les coordonnées de l'image
                this.updateBackgroundImage(); // Mettre à jour l'image de fond
            } catch (error) {
                console.error(error);
            }
        },
        startTimer() {
            if (!this.timerInterval) {
                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining === 0) {
                        clearInterval(this.timerInterval);
                        this.currentRound++;
                        // Si l'utilisateur n'a pas cliqué sur le bouton "Envoyer"
                        if (!this.markers.length) {
                            // Ajouter 0 au score
                            this.updateScore(0);
                        }
                        this.redirectToFinRound();
                    } else {
                        this.timeRemaining--;
                    }
                }, 1000);
            }
        },
        updateImageCoordinates() {
            if (this.currentLieu && this.currentLieu.localisation) {
                this.imageCoordinates = this.currentLieu.localisation.coordinates;
            }
        },
        updateBackgroundImage() {
            if (this.currentLieu && this.currentLieu.nom) {
                this.backgroundImage = this.currentLieu.nom;
            }
        },
        pauseTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        },
        toggleTimer() {
            if (this.timerInterval) {
                this.pauseTimer();
                this.isPaused = true;
            } else {
                this.startTimer();
                this.isPaused = false;
            }
        },
        redirectToFinRound() {
            if (this.currentRound >= 6) {
                this.$router.push('/FinJeu');
            } else {
                this.$router.push('/FinRound');
            }
        },
        checkDistance() {
            // Calculer la distance entre chaque marqueur et les coordonnées de l'image
            this.markers.forEach(marker => {
                const distance = this.calculateDistance(marker.coordinates, this.imageCoordinates);
                this.updateScore(distance);
            });

            // Passer au round suivant
            this.currentRound++;
            this.resetTimer();

            // Charger le prochain lieu
            this.currentLieu = this.lieux[this.currentRound - 1];
            this.updateImageCoordinates();
            this.updateBackgroundImage();

            // Si c'est le dernier round, rediriger vers la fin du jeu
            if (this.currentRound >= 6) {
                this.redirectToFinRound();
            }
        },
        calculateDistance(coord1, coord2) {
            return Math.sqrt(Math.pow(coord1[0] - coord2[0], 2) + Math.pow(coord1[1] - coord2[1], 2));
        },
        updateScore(distance) {
            if (distance < 0.01) {
                this.score += 5;
            } else if (distance < 0.05) {
                this.score += 3;
            } else if (distance < 0.1) {
                this.score += 1;
            } else {
                this.score += 0;
            }
            this.totalScore += this.score;
        },
        onMapClick(event) {
            // Ajouter un nouveau marqueur aux coordonnées du clic
            this.markers.push({
                coordinates: [event.latlng.lat, event.latlng.lng]
            });
        },
        resetTimer() {
            // Réinitialiser le temps restant
            this.timeRemaining = 30;
        }
    },
    mounted() {
        this.startTimer();
        this.getLieux();
    }
};
</script>



<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lalezar&display=swap');
.greetings {
    position: relative;
}

    .lalezar-regular {
        font-family: "Lalezar", system-ui;
        font-weight: 400;
    }
button {
  text-decoration: none;
}
.logo {
    display: flex;
    align-items: center;
    font-size: 2em;
    z-index: 1;
    color: white;
    position: absolute;
    top: 0;
    left: 0;
    margin-left: 20px;
}



.logo img {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    padding-right: 10px;
}
.logo h1 {
    text-shadow: 2px 2px 4px rgba(92, 83, 214, 0.5);
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
    width: 80%;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: width 0.3s ease, height 0.3s ease;
    /* Ajout de la transition de taille */
    position: absolute;
    bottom: 0;
    right: 0;
    margin: 10px;
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
    margin: 10px;
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
}</style>
