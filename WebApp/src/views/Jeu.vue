<script>
import 'leaflet/dist/leaflet.css';
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';

export default {
    name: 'CarteOs',
    components: {
        LMap,
        LTileLayer,
        LMarker
    },
    data() {
        return {
            osmURL: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            center: [48.694, 6.18],
            zoom: 10,
            maxZoom: 18,
            minZoom: 1,
            marker: null,
            timeRemaining: 30,
            timerInterval: null,
            score: 0
        };
    },
    methods: {
        onMapClick(event) {
            if (this.marker) {
                this.marker.coordinates = [event.latlng.lat, event.latlng.lng];
                // Mise à jour du score lorsqu'un marqueur est placé
                this.updateScore();
            } else {
                this.marker = {
                    id: 1,
                    coordinates: [event.latlng.lat, event.latlng.lng]
                };
            }
        },
        updateScore() {
            // Mettez à jour le score ici, par exemple, ajoutez 100 points
            this.score += 100;
        },
        toggleTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            } else {
                this.startTimer();
            }
        },
        startTimer() {
            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                } else {
                    clearInterval(this.timerInterval);
                    // Le temps est écoulé, vous pouvez gérer ce cas ici
                }
            }, 1000);
        },
    },
    mounted() {
        this.startTimer();
    }
};
</script>

<template>
    <div class="greetings">


        <img src="@/assets/placestan.jpg" alt="Place Stanislas" class="game-image" />

        <div class="logo">
            <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
            <h1>GéoQuizz</h1>

        </div>
        <div class="score">
            <h2>Score : {{ score }}</h2>
        </div>
        <div class="map-container">
            <l-map ref="map" class="map" v-model:center="center" v-model:zoom="zoom" :max-zoom="maxZoom" :min-zoom="minZoom"
                :zoom-control="false" :use-global-leaflet="false" @click="onMapClick">
                <l-tile-layer :url="osmURL" />
                <l-marker v-if="marker" :lat-lng="marker.coordinates"></l-marker>
            </l-map>
            <button>Envoyer</button>
        </div>
        <div class="timer">
            <button @click="toggleTimer"><img src="@/assets/pause.png" alt="pause" class="pause" /></button>
            <h2>Temps restant : {{ timeRemaining }}</h2>
        </div>
    </div>
</template>


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

.score {

    background-color: #2B80B0;
    z-index: 1;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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

.game-image {
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 0;
}

.map-container {
    height: 300px;
    width: 400px;
    position: absolute;
    bottom: 0;
    right: 0;
    
    z-index: 1;
    margin: 10px;
}

.map {
    border-radius: 20px;
    width: 100%;
    height: 100%;
}

.map-container button {
    font-size: 40px;
    font-style: bold;
    width: 100%;
    background-color: #4AC78D;
    color: white;
    padding: 10px;
    border-radius: 10px;
    margin: 10px;
    cursor: pointer;
    border: none;
    margin-right: 30px;
}
</style>
