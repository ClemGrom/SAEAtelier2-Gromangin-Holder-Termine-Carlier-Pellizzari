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
            center: [48.694, 6.18],
            zoom: 10,
            maxZoom: 18,
            minZoom: 1,
            marker: null,
            timeRemaining: 30,
            timerInterval: null,
            score: 0,
            isMapExpanded: false,
            imageCoordinates: [48.6936219, 6.1806664],
            currentRound: 1
        };
    },
    methods: {
        // Méthode pour récupérer les données de localStorage
        retrieveData() {
            const savedScore = localStorage.getItem('score');
            const savedRound = localStorage.getItem('round');
            if (savedScore && savedRound) {
                this.score = parseInt(savedScore);
                this.currentRound = parseInt(savedRound);
            }
        },
        // Méthode pour sauvegarder les données dans localStorage
        saveData() {
            localStorage.setItem('score', this.score.toString());
            localStorage.setItem('round', this.currentRound.toString());
        },
        onMapClick(event) {
    if (!this.marker) {
        this.marker = {
            coordinates: [event.latlng.lat, event.latlng.lng]
        };
    } else {
        // Remplacez le marqueur existant par le nouveau
        this.marker.coordinates = [event.latlng.lat, event.latlng.lng];
    }
},
        toggleTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
                this.redirectToFinRound(); // Redirection vers la fin du tour lorsque le temps est mis en pause
            } else {
                this.startTimer();
            }
        },
        startTimer() {
            this.timerInterval = setInterval(() => {
                if (this.timeRemaining === 0) { // Utilisation de === pour une comparaison stricte
                    clearInterval(this.timerInterval);
                    this.currentRound++; // Utilisation de this.currentRound pour accéder à la propriété de l'instance
                    this.redirectToFinRound();
                } else {
                    this.timeRemaining--; // Redirection vers la fin du tour lorsque le temps est écoulé
                }
            }, 1000);
        },

        redirectToFinRound() {
            // Redirection vers la fin du tour
            this.$router.push('/FinRound');
        },
        expandMap() {
            this.isMapExpanded = true;
        },
        shrinkMap() {
            this.isMapExpanded = false;
        },
        checkDistance() {
            if (this.marker) {
                // Calculez la distance entre les coordonnées du marqueur et les coordonnées de l'image associée
                const distance = this.calculateDistance(this.marker.coordinates, this.imageCoordinates);
                // Mettez à jour le score en fonction de la proximité du marqueur avec les coordonnées de l'image
                // Vous pouvez ajuster cette logique en fonction de vos besoins spécifiques
                this.updateScore(distance);
                // Réinitialisez le marqueur pour permettre au joueur de placer un nouveau marqueur pour le prochain tour
                this.marker = null;
                // Passez au tour suivant si nécessaire
                if (this.currentRound < 5) {
                    this.currentRound++;
                } else {
                    // Rediriger vers FinJeu.vue si le nombre de tours dépasse 5
                    this.$router.push('/FinJeu');
                }

            } else {
                console.log("Veuillez placer un marqueur avant d'envoyer.");
            }
        },
        calculateDistance(coord1, coord2) {
            // Implémentez la fonction de calcul de la distance entre deux paires de coordonnées
            // Par exemple, vous pouvez utiliser la formule de la distance euclidienne ou d'autres méthodes de calcul de distance géographique
            // Cette fonction doit retourner la distance calculée
            return Math.sqrt(Math.pow(coord1[0] - coord2[0], 2) + Math.pow(coord1[1] - coord2[1], 2));
        },
        updateScore(distance) {
            // Mettez à jour le score en fonction de la distance calculée
            // Vous pouvez ajuster cette logique en fonction de vos besoins spécifiques
            if (distance < 0.01) {
                this.score += 5; // Score maximum si le marqueur est très proche de l'image
            } else {
                this.score += 3; // Score partiel si le marqueur est proche mais pas exactement sur l'image
            }
        }
    },
    mounted() {
        this.retrieveData(); // Récupérer les données sauvegardées lors du chargement du composant
        this.startTimer();
    },
    watch: {
        // Surveiller les changements de score et de tour et les sauvegarder automatiquement
        score: function (newScore) {
            this.saveData();
        },
        currentRound: function (newRound) {
            this.saveData();
            // Rediriger vers FinJeu.vue si le nombre de tours dépasse 5
            if (newRound >= 5) {
                this.$router.push('/FinJeu');
            }
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
