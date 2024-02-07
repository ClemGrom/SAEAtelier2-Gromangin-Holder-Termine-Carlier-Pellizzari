<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-dark">
        <div class="row w-100 text-dark bg-light">
            <div class="col-lg-12">
                <h2 class="main-title text-center">Choix de la difficulté : </h2>
                <div class="d-flex justify-content-around mt-5">
                    <button class="btn text-success" :class="{ 'bg-button': difficulty === 'easy' }" @click="setDifficulty('easy')">Facile</button>
                    <button class="btn text-warning" :class="{ 'bg-button': difficulty === 'normal' }" @click="setDifficulty('normal')">Normal</button>
                    <button class="btn text-danger" :class="{ 'bg-button': difficulty === 'hard' }" @click="setDifficulty('hard')">Difficile</button>
                </div>
            </div>
            <div class="col-lg-12">
                <h2 class="main-title text-center">Choix de la série</h2>
                <div class="mt-5 series-container row">
                    <div v-for="series in seriesOptions" :key="series.value" class="series-card col-lg-3 mb-2">
                        <h3>{{ series.text }}</h3>
                        <p>{{ series.description }}</p>
                        <p>Meilleur score : {{ series.bestScore }}</p>
                        <button class="btn btn-success" @click="setSeries(series.value)">Choisir cette série</button>
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
                { value: 'series5', text: 'Série 5', description: 'Description de la série 5', bestScore: 500}
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


.row {
    color: #000;
    background-color: #f8f9fa;
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
    transition: background-color 0.3s;
}

.btn-success {
    color: #ecf0f1;
    background-color: #4AC78D;
}

.btn-success:hover {
    background-color: #2980b9;
}

.bg-button {
    background-color: #bababa6e;
}

.series-container {
    overflow-y: auto;
    max-height: 400px;
}

.series-card {
    padding: 20px;
    margin: 20px;
    margin-left: 70px;
}
</style>