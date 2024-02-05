<template>
  <div class="profile-container">
    <router-link to="/" class="back-link">
      <span class="arrow">&larr;</span> Retour à l'accueil
    </router-link>

    <h2 class="page-title">Mon profil</h2>

    <div class="section">
      <h3 class="section-title">Historique de mes parties</h3>
      <ul class="game-list">
        <li v-for="game in gamesHistory" :key="game.id">
          <span class="bullet">&#8226;</span> {{ game.name }} - {{ game.score }} points
        </li>
      </ul>
    </div>

    <div class="section">
      <h3 class="section-title">Mes Scores effectués</h3>
      <ul class="score-list">
        <li v-for="score in scores" :key="score.id">
          <span class="bullet">&#8226;</span> {{ score.value }} points - {{ score.date }}
        </li>
      </ul>
    </div>

    <div class="section">
      <h3 class="section-title">Mes High-Scores par séries </h3>
      <ul class="high-score-list">
        <li v-for="userHighScore in userHighScores" :key="userHighScore.id">
          <span class="bullet">&#8226;</span> {{ userHighScore.seriesName }} - {{ userHighScore.points }} points
        </li>
      </ul>
    </div>

    <div class="section">
      <h3 class="section-title">High-Scores par séries (global) </h3>
      <ul class="high-score-list">
        <li><span class="bullet">&#8226;</span> Série 1 - 200 points</li>
        <li><span class="bullet">&#8226;</span> Série 2 - 180 points</li>
        <li><span class="bullet">&#8226;</span> Série 3 - 170 points</li>
        <li><span class="bullet">&#8226;</span> Série 4 - 160 points</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      gamesHistory: [
        { id: 1, name: 'Partie 1', score: 120 },
        { id: 2, name: 'Partie 2', score: 95 },
        { id: 3, name: 'Partie 3', score: 110 },
        { id: 4, name: 'Partie 4', score: 80 },
      ],
      scores: [
        { id: 1, value: 150, date: '01/02/2024' },
        { id: 2, value: 110, date: '03/02/2024' },
        { id: 3, value: 130, date: '05/02/2024' },
        { id: 4, value: 90, date: '08/02/2024' },
      ],
      userHighScores: [
        { id: 1, seriesName: 'Série 1', points: 180 },
        { id: 2, seriesName: 'Série 2', points: 150 },
        { id: 3, seriesName: 'Série 3', points: 140 },
        { id: 4, seriesName: 'Série 4', points: 130 },
      ],
    };
  },
};

</script>

<style scoped>

.bullet {
  color: #e74c3c;
  margin-right: 5px;
  display: inline-block;
}

.profile-container {
  text-align: center;
  padding: 20px;
  background: #2c3e50;
  border-radius: 15px;
  box-shadow: 0 8px 16px rgba(255, 123, 95, 0.3);
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.page-title {
  font-size: 36px;
  color: #ffffff;
  margin-bottom: 20px;
}

.section {
  margin-top: 30px;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 100%;
}

.section-title {
  font-size: 28px;
  color: #333;
  margin-bottom: 15px;
}

.game-list,
.score-list,
.high-score-list {
  list-style: none;
  padding: 0;
}

.game-list li,
.score-list li {
  margin-bottom: 10px;
}

.game-list li,
.score-list li,
.high-score-list li {
  margin-bottom: 10px;
}

.game-list span.bullet,
.score-list span.bullet,
.high-score-list span.bullet {
  vertical-align: middle;
  margin-right: 5px;
}

.back-link {
  margin-top: 20px;
  margin-right: 370px;
  color: white;
  text-decoration: underline;
  font-weight: bold;
}

</style>
