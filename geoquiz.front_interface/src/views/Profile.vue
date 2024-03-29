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
          <select class="custom-select game-select" v-model="selectedGame">
            <option disabled selected>Sélectionnez votre partie jouée pour voir sa chronologie</option>
            <option v-for="game in gamesHistory" :key="game.id" :value="game.id">
              {{ game.startTime }} - {{ game.score }} points
            </option>
          </select>
          <div class="select-icon"><i class="fas fa-gamepad"></i></div>
        </div>
        <div class="game-details" v-if="selectedGame">
          <p><span class="detail-label">Statut :</span> {{ selectedGameStatus }}</p>
          <p><span class="detail-label">Score :</span> {{ selectedGameScore }} points</p>
          <p><span class="detail-label">Difficulté :</span> {{ selectedGameDifficulty }}</p>
          <p><span class="detail-label">Débuté le :</span> {{ selectedGameStartTime }}</p>
          <p><span class="detail-label">Terminé le :</span> {{ selectedGameEndTime }}</p>
        </div>
      </div>

      <div class="section">
        <h3 class="section-title">Mes High-Scores par séries</h3>
        <div class="select-container">
          <select class="custom-select user-score-select" v-model="selectedUserHighScore">
            <option disabled selected>Choisissez la série que vous voulez voir</option>
            <option v-for="userHighScore in userHighScores" :key="userHighScore.serie" :value="userHighScore.serie">
              {{ userHighScore.serie }}
            </option>
          </select>
          <div class="select-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="user-highscore-details" v-if="selectedUserHighScore">
          <p><span class="detail-label">Votre score le plus élevé :</span> {{ selectedUserHighScorePoints }} points</p>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import gameService from "@/services/gameService.js";

export default {
  data() {
    return {
      gamesHistory: [],
      userHighScores: [],
      selectedGame: '',
      selectedScore: '',
      selectedUserHighScore: '',
    };
  },
  computed: {
    selectedGameStartTime() {
      const game = this.gamesHistory.find(game => game.id === this.selectedGame);
      return game ? game.startTime : '';
    },
    selectedGameEndTime() {
      const game = this.gamesHistory.find(game => game.id === this.selectedGame);
      return game ? game.endTime : '';
    },
    selectedGameDifficulty() {
      const game = this.gamesHistory.find(game => game.id === this.selectedGame);
      return game ? game.difficulty : '';
    },
    selectedGameStatus() {
      const game = this.gamesHistory.find(game => game.id === this.selectedGame);
      return game ? game.status : '';
    },
    selectedGameScore() {
      const game = this.gamesHistory.find(game => game.id === this.selectedGame);
      return game ? game.score : '';
    },

    selectedUserHighScorePoints() {
      const userHighScore = this.userHighScores.find(score => score.serie === this.selectedUserHighScore);
      return userHighScore ? userHighScore.points : '';
    },
  },
  methods: {
    gamesHistoryComputed() {
      return gameService.getGamesFromUser().then(response => {
        response = response.map(
            game => ({
              id: game.game_id,
              difficulty: game.difficulty.level_name,
              status: game.status,
              score: game.score,
              startTime: game.created_at,
              endTime: game.finished_at,
              serie: game.serie.serie_id
            })
        )
        console.log("mapped games: ", response);

        //compute high score per serie and set userHighScores
        const highScores = response.reduce((acc, game) => {
          if (!acc[game.serie]) {
            acc[game.serie] = game.score;
          } else {
            acc[game.serie] = Math.max(acc[game.serie], game.score);
          }
          return acc;
        }, {});

        this.userHighScores = Object.keys(highScores).map(serie => ({
          serie,
          points: highScores[serie]
        }));


        this.gamesHistory = response;
        return response;
      })
    },
  },
  mounted() {
    this.gamesHistoryComputed();
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
