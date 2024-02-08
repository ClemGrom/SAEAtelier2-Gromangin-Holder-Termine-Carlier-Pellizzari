<template>
  <div class="profile-container">
    <router-link to="/" class="back-link">
      Retourner à l'accueil
    </router-link>

    <h2 class="page-title">Mon profil</h2>

    <div class="grid-container">
      <div class="section">
        <h3 class="section-title">Historique de mes parties effectuées</h3>
        <div class="select-container">
          <select class="custom-select game-select" v-model="selectedGame" @change="showGameDetails">
            <option disabled selected>Sélectionnez votre partie jouée pour voir sa chronologie</option>
            <option v-for="game in gamesHistory" :key="game.id">{{ game.name }}</option>
          </select>
          <div class="select-icon"><i class="fas fa-gamepad"></i></div>
        </div>
        <div class="game-details" v-if="selectedGame">
          <p><span class="detail-label">Débuté le :</span> {{ selectedGameStartTime }}</p>
          <p><span class="detail-label">Terminé le :</span> {{ selectedGameEndTime }}</p>
        </div>
      </div>

      <div class="section">
        <h3 class="section-title">Vos scores par parties effectuées</h3>
        <div class="select-container">
          <select class="custom-select score-select" v-model="selectedScore" @change="showGameScore">
            <option disabled selected>Sélectionnez une partie effectuée pour revoir votre score</option>
            <option v-for="score in scores" :key="score.id">{{ score.name }}</option>
          </select>
          <div class="select-icon"><i class="fas fa-trophy"></i></div>
        </div>
        <div class="score-details" v-if="selectedScore">
          <p><span class="detail-label">Votre score :</span> {{ selectedScoreValue }} points</p>
        </div>
      </div>

      <div class="section">
        <h3 class="section-title">Mes High-Scores par séries</h3>
        <div class="select-container">
          <select class="custom-select user-score-select" v-model="selectedUserHighScore">
            <option disabled selected>Choisissez la série que vous voulez voir</option>
            <option v-for="userHighScore in userHighScores" :key="userHighScore.id">{{ userHighScore.seriesName }}</option>
          </select>
          <div class="select-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="user-highscore-details" v-if="selectedUserHighScore">
          <p><span class="detail-label">Votre score le plus élevé :</span> {{ selectedUserHighScorePoints }} points</p>
        </div>
      </div>

      <div class="section">
        <h3 class="section-title">High-Scores par séries (global)</h3>
        <div class="select-container">
          <select class="custom-select global-score-select" v-model="selectedGlobalHighScore">
            <option disabled selected>Choisissez la série que vous voulez voir</option>
            <option v-for="globalHighScore in globalHighScores" :key="globalHighScore.id">{{ globalHighScore.seriesName }}</option>
          </select>
          <div class="select-icon"><i class="fas fa-globe"></i></div>
        </div>
        <div class="global-highscore-details" v-if="selectedGlobalHighScore">
          <p><span class="detail-label">Record à battre !</span> {{ selectedGlobalHighScorePoints }} points</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      gamesHistory: [
        { id: 4, name: 'Partie 4', startTime: '2024-02-04 09:45:00', endTime: '2024-02-04 11:00:00' },
        { id: 3, name: 'Partie 3', startTime: '2024-02-03 10:30:00', endTime: '2024-02-03 11:15:00' },
        { id: 2, name: 'Partie 2', startTime: '2024-02-02 15:00:00', endTime: '2024-02-02 16:45:00' },
        { id: 1, name: 'Partie 1', startTime: '2024-02-01 13:00:00', endTime: '2024-02-01 14:30:00' },
      ],
      scores: [
        { id: 4, name: 'Partie 4', value: 90 },
        { id: 3, name: 'Partie 3', value: 130 },
        { id: 2, name: 'Partie 2', value: 95 },
        { id: 1, name: 'Partie 1', value: 120 },
      ],
      userHighScores: [
        { id: 4, seriesName: 'Série 4', points: 130 },
        { id: 3, seriesName: 'Série 3', points: 140 },
        { id: 2, seriesName: 'Série 2', points: 150 },
        { id: 1, seriesName: 'Série 1', points: 180 },

      ],
      globalHighScores: [
        { id: 4, seriesName: 'Série 4', points: 160 },
        { id: 3, seriesName: 'Série 3', points: 170 },
        { id: 2, seriesName: 'Série 2', points: 180 },
        { id: 1, seriesName: 'Série 1', points: 200 },

      ],
      selectedGame: '',
      selectedScore: '',
      selectedUserHighScore: '',
      selectedGlobalHighScore: ''
    };
  },
  computed: {
    selectedGameStartTime() {
      const game = this.gamesHistory.find(game => game.name === this.selectedGame);
      return game ? game.startTime : '';
    },
    selectedGameEndTime() {
      const game = this.gamesHistory.find(game => game.name === this.selectedGame);
      return game ? game.endTime : '';
    },
    selectedScoreValue() {
      const score = this.scores.find(score => score.name === this.selectedScore);
      return score ? score.value : '';
    },
    selectedUserHighScorePoints() {
      const userHighScore = this.userHighScores.find(score => score.seriesName === this.selectedUserHighScore);
      return userHighScore ? userHighScore.points : '';
    },
    selectedGlobalHighScorePoints() {
      const globalHighScore = this.globalHighScores.find(score => score.seriesName === this.selectedGlobalHighScore);
      return globalHighScore ? globalHighScore.points : '';
    }
  },
  methods: {
    showGameDetails() {
      const selectedGame = this.gamesHistory.find(game => game.name === this.selectedGame);
      if (selectedGame) {
        alert(`${selectedGame.name}\nDate de début : ${selectedGame.startTime}\nDate de fin : ${selectedGame.endTime}`);
      }
    },
    showGameScore() {
      const selectedScore = this.scores.find(score => score.name === this.selectedScore);
      if (selectedScore) {
        alert(`${selectedScore.name}\nVotre score est de ${selectedScore.value} points`);
      }
    },
    showUserHighScore() {
      alert(`${this.selectedUserHighScore}\nVotre score le plus haut est de ${this.selectedUserHighScorePoints} points, bravo !`);
    },
    showGlobalHighScore() {
      alert(`${this.selectedGlobalHighScore}\nLe record à battre est de ${this.selectedGlobalHighScorePoints} points, à vous de jouer !`);
    }
  }
};
</script>

<style scoped>
.profile-container {
  text-align: center;
  padding: 20px;
  background-color: #2c3e50;
  border-radius: 15px;
  color: white;
}

.page-title {
  font-size: 36px;
  margin-bottom: 20px;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.section {
  padding: 20px;
  background-color: #34495e;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: relative;
}

.section-title {
  font-size: 28px;
  color: #ecf0f1;
  margin-bottom: 15px;
}

.custom-select {
  width: calc(100% - 40px);
  padding: 10px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  background-color: #2c3e50;
  cursor: pointer;
  color: white;
  outline: none;
}

.select-container {
  position: relative;
}

.select-icon {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  color: #ecf0f1;
}

.back-link {
  margin-top: 20px;
  color: #3498db;
  text-decoration: none;
  font-weight: bold;
}

.back-link:hover {
  text-decoration: underline;
}

.game-details, .score-details, .user-highscore-details, .global-highscore-details {
  margin-top: 10px;
  padding: 10px;
  background-color: #2c3e50;
  border-radius: 5px;
}

.detail-label {
  font-weight: bold;
  color: #3498db;
}
</style>
