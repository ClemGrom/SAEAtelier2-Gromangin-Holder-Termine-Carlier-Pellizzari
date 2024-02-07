<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-custom">
        <div class="row w-100 text-white">
            <h2 class="main-title text-center rounded">Choix de la difficulté : </h2>
            <div class="col-lg-12 ">
                    <div class="d-flex justify-content-around mt-5 text-dark ">
                        <button class="btn text-white btn-no-hover" :class="{ 'bg-success': difficulty === 'easy' }"
                            @click="setDifficulty('easy')">Facile</button>
                        <button class="btn text-white btn-no-hover" :class="{ 'bg-warning': difficulty === 'normal' }"
                            @click="setDifficulty('normal')">Normal</button>
                        <button class="btn text-white btn-no-hover" :class="{ 'bg-danger': difficulty === 'hard' }"
                            @click="setDifficulty('hard')">Difficile</button>
                    </div>
                </div>
            <div class="bg-white rounded">
               
                <div class="col-lg-12 bg-white text-dark">
                    <h2 class="main-title text-center">Choix de la série</h2>
                    <div class="mt-5 series-container row ">
                        <div v-for="series in seriesOptions" :key="series.value"
                            class="series-card col-lg-3 mb-2 bg-custom text-white rounded">
                            <h3>{{ series.text }}</h3>
                            <p>{{ series.description }}</p>
                            <p>Meilleur score : {{ series.bestScore }}</p>
                            <button class="btn btn-success" @click="setSeries(series.value)">Choisir cette série</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            difficulty: 'easy',
            series: '',
            seriesOptions: [
                { value: 'series1', text: 'Série 1', description: 'Description de la série 1', bestScore: 100 },
                { value: 'series2', text: 'Série 2', description: 'Description de la série 2', bestScore: 200 },
                { value: 'series3', text: 'Série 3', description: 'Description de la série 3', bestScore: 300 },
                { value: 'series4', text: 'Série 4', description: 'Description de la série 4', bestScore: 400 },
                { value: 'series5', text: 'Série 5', description: 'Description de la série 5', bestScore: 500 }
            ],
        };
    },
    methods: {
        setDifficulty(difficulty) {
            this.difficulty = difficulty;
        },
        setSeries(series) {
            this.series = series;
        },
        createGame() {
            // Implémentez la logique de création de la partie ici
        },
    },
};
</script>
  
<style scoped>
.bg-custom {
    background-color: #22364B;
}

.row {
    margin-left: 5%;
    margin-right: 5%;
}

.main-title {
    font-size: 48px;
    margin-bottom: 20px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.btn {
    padding: 15px 30px;
    font-size: 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
    background-color: #22364B;
}

.btn-success {
    color: #ecf0f1;
    background-color: #4AC78D;
}

.btn-success:hover {
    background-color: #2980b9;
}

.btn-no-hover:hover {
    background-color: inherit !important;
}

.bg-button {
    background-color: #534f4f6e;
}

.series-container {
    overflow-y: auto;
    max-height: 400px;
}

.series-card {
    padding: 20px;
    margin: 20px;
    margin-left: 70px;
}</style>
  