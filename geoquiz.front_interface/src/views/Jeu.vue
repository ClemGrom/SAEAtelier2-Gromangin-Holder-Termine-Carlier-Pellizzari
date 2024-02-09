<template>
    <div class="greetings lalezar-regular">
        <img :src="'http://docketu.iutnc.univ-lorraine.fr:50010/assets/' + fondImage" alt="Place Stanislas"
            class="game-image" />

        <div class="logo">
            <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
            <h1>GéoQuizz</h1>
        </div>

        <div class="score">
            <h2>Score : {{ totalScore }} Round : {{ currentRound }}/5</h2>
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
            center: [0, 0],
            zoom: 1,
            maxZoom: 18,
            minZoom: 1,
            marker: null,
            timeRemaining: 60,
            timerInterval: null,
            score: 0,
            isPaused: false,
            totalScore: 0,
            isMapExpanded: false,
            imageCoordinates: [48.6936219, 6.1806664],
            currentRound: 1,
            lieux: [],
            fondImage: null,
            index: 0,
            serie: null,
            stopTimer: false,
        };
    },
    mounted() {
        this.serie = JSON.parse(localStorage.getItem('infosSeries'));
            try {
                this.center = [this.serie.defaultLong, this.serie.defaultLat]
                this.zoom = this.serie.zoom;
                this.maxZoom = this.serie.maxZoom;
                this.minZoom = this.serie.minZoom;
            } catch (error) {
                console.error('Les données des séries ne sont pas au format attendu.');
            }
        this.game();
    },
    methods: {
        game() {
            this.index = localStorage.getItem('index');

            const parsedInfosLieux = JSON.parse(localStorage.getItem('infosLieux'));
            try {
                this.lieux = parsedInfosLieux.data;
                const currentLieu = this.lieux[this.index];
                this.imageCoordinates = currentLieu.localisation.coordinates;
                console.log(this.imageCoordinates);

                this.fondImage = currentLieu.image;
            } catch (error) {
                console.error('Les données des lieux ne sont pas au format attendu.');
            }

            
            this.totalScore = parseInt(localStorage.getItem('totalScore')) || 0;
            this.currentRound = parseInt(localStorage.getItem('currentRound')) || 1;
            this.stopTimer = false;
            this.timeRemaining = 60;

            this.startTimer();
        },


        startTimer() {
            if (!this.timerInterval && !this.stopTimer) {
                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining === 0 || this.stopTimer) {
                        clearInterval(this.timerInterval);
                        this.timerInterval = null;
                        if (this.timeRemaining === 0) {
                            this.currentRound++;
                            localStorage.setItFem('currentRound', this.currentRound);
                            this.redirectToFinRound();
                        }
                    } else if (!this.isPaused) {
                        this.timeRemaining--;
                    }
                }, 1000);
            }
        },

        pauseTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
                this.isPaused = true;
            }
        },
        toggleTimer() {
    this.isPaused = !this.isPaused;
},
        redirectToFinRound() {
            if (this.currentRound >= 6) {


                this.pauseTimer();
                this.index++;
                this.stopTimer = true;
                localStorage.setItem('index', this.index);

                this.$router.push('/FinJeu');
            } else {
                this.pauseTimer();
                this.stopTimer = true;
                this.index++;
                localStorage.setItem('index', this.index);
                this.$router.push('/FinRound');
            }
        },
        checkDistance() {
            if (this.marker) {
                const distance = this.calculateDistance(this.marker.coordinates, this.imageCoordinates);
                console.log(distance);
                this.updateScore(distance);
                this.marker = null;
                this.currentRound++;
                localStorage.setItem('currentRound', this.currentRound);
                this.redirectToFinRound();


            }
        },
        calculateDistance(coord1, coord2) {
            return Math.sqrt(Math.pow(coord1[0] - coord2[0], 2) + Math.pow(coord1[1] - coord2[1], 2)) / 2;
        },
        updateScore(distance) {
            if (distance < 5) {
                this.score = 10 * this.timeRemaining;
            } else if (distance < 25) {
                this.score = 5 * this.timeRemaining;
            } else if (distance < 100) {
                this.score = 2 * this.timeRemaining;
            } else if (distance < 200) {
                this.score = this.timeRemaining;
            }
            else {
                this.score = 0;
            }
            this.totalScore += this.score;
            localStorage.setItem('score', this.score);
            localStorage.setItem('totalScore', this.totalScore);
        },
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
    z-index: 5;
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
    /* Assurez-vous que le popup apparaît au-dessus de tout le reste */
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
}
</style>
