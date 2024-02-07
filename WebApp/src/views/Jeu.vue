<template>
    <div class="greetings">
        <img src="@/assets/placestan.jpg" alt="Place Stanislas" class="game-image" />

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
                <l-marker v-if="marker" :lat-lng="marker.coordinates"></l-marker>
            </l-map>
            <router-link :to="{ path: '/FinRound' }" class="custom-button" @click="checkDistance">Envoyer</router-link>
        </div>

        <div class="timer">
            <button @click="toggleTimer" class="timer-button">
                <img src="@/assets/pause.png" alt="pause" class="pause" />
            </button>
            <h2>Temps restant : {{ timeRemaining }}</h2>
        </div>
    </div>
</template>

<script>
import 'leaflet/dist/leaflet.css';
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';

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
            center: [48.694, 6.18],// va changer avec dirctus
            zoom: 10,
            maxZoom: 18,
            minZoom: 1,
            marker: null,
            timeRemaining: 30,
            timerInterval: null,
            score: 0,
            totalScore : 0,
            isMapExpanded: false,
            imageCoordinates: [48.6936219, 6.1806664],//achanger dans disrectus 
            currentRound: 1
        };
    },
    methods: {

        // fetch api axios?
        startTimer() {
            if (!this.timerInterval) {
                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining === 0) {
                        clearInterval(this.timerInterval);
                        this.currentRound++;
                        localStorage.setItem('currentRound', this.currentRound);
                        
                        // Si l'utilisateur n'a pas cliqué sur le bouton "Envoyer"
                        if (!this.marker) {
                            // Ajouter 0 au score
                            this.updateScore(1);
                        }
                        this.redirectToFinRound();
                    } else {
                        this.timeRemaining--;
                    }
                }, 1000);
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
            } else {
                this.startTimer();
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
            if (this.marker) {
                const distance = this.calculateDistance(this.marker.coordinates, this.imageCoordinates);
                this.updateScore(distance);
                this.marker = null;
                if (this.currentRound < 6) {
                    this.currentRound++;
                    // Save the number of rounds in LocalStorage
                    localStorage.setItem('currentRound', this.currentRound);
                    this.pauseTimer();
                    this.timeRemaining = 30;
                }
                // Check if currentRound is greater than or equal to 5 after incrementing it
                if (this.currentRound >= 6) {
                    this.$router.push('/FinJeu');
                }
            }
        },
        calculateDistance(coord1, coord2) {
            return Math.sqrt(Math.pow(coord1[0] - coord2[0], 2) + Math.pow(coord1[1] - coord2[1], 2));
        },
        updateScore(distance) {
            if (distance < 0.01) {
                this.score = 5* this.timeRemaining;
            } else if (distance < 0.05) {
                this.score = 5 * this.timeRemaining;

            } else if (distance < 0.1) {
                this.score = 1 * this.timeRemaining;
            }
            else {
                this.score = 0;

            }
            this.totalScore +=this.score;
            localStorage.setItem('score', this.score);
            localStorage.setItem('totalScore',this.totalScore);
        },
        onMapClick(event) {
    this.marker = {
        coordinates: [event.latlng.lat, event.latlng.lng]
    };
},
        beforeRouteLeave(to, from, next) {
            this.pauseTimer();
            this.timeRemaining = 30;
            next();
        },
    },
    mounted() {
        this.startTimer();
        const savedRound = localStorage.getItem('currentRound');
        const savedTotalScore = localStorage.getItem('totalScore');
        const savedScore = localStorage.getItem('score');
        if (savedRound) {
            this.currentRound = Number(savedRound);
        }
        if (savedScore) {
            this.score = Number(savedScore);
        }
        if (savedTotalScore){
            this.totalScore = Number(savedTotalScore);
        }
    }
};
</script>


<style scoped>
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
    bottom: 0;
    right: 0;
    margin: 10px;
}

.custom-button:hover {
    background-color: #3fa670;
}
</style>
