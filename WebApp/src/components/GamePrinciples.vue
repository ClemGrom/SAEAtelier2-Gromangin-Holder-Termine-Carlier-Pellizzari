<template>
  <div class="home-container">
    <div class="gray-container">
      <div class="content-container">
        <div class="content-section" :class="{ 'active': showPrinciples }" @click="togglePrinciplesDisplay">
          <h2 class="section-title">Principe et règles du jeu</h2>
          <div class="divider"></div>
        </div>
        <div class="content-section" :class="{ 'active': showPoints }" @click="togglePointsDisplay">
          <h2 class="section-title">Calculer ses points </h2>
          <div class="divider"></div>
        </div>
      </div>
      <div class="text-container">
        <div v-if="showPrinciples" class="text-content">
          <ul class="game-rules">
            <li>Une partie consiste en une séquence de 10 photos aléatoires d'une même série, à placer sur la carte de la ville.</li>
            <li>Chaque série regroupe des photos de la même ville et de la même carte.</li>
            <li>Vous gagnez des points en fonction de la précision du placement et de la rapidité de votre réponse.</li>
            <li>L'objectif est d'obtenir le maximum de points au cours d'une partie de 10 photos.</li>
            <li>La partie se termine une fois que toutes les 10 photos ont été positionnées.</li>
          </ul>
        </div>
        <div v-if="showPoints" class="text-content">
          <ul class="game-rules">
            <p>Placement des réponses</p>
            <li>pour 1 réponse placée à une distance &lt; D : <span class="point-value">5pts</span></li>
            <li>pour 1 réponse placée à une distance &lt; 2D : <span class="point-value">3pts</span></li>
            <li>pour 1 réponse placée à une distance &lt; 3D : <span class="point-value">1pts</span></li>
          </ul>
          <ul class="game-rules">
            <p>Prise en compte de la rapidité</p>
            <li>les points sont multipliés par 4 pour une réponse en moins de 5s</li>
            <li>les points sont multipliés par 2 pour 1 réponse en moins de 10s</li>
            <li>les points ne sont pas acquis pour 1 réponse en plus de 20s</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showPrinciples: true,
      showPoints: false
    };
  },
  methods: {
    togglePrinciplesDisplay() {
      this.showPrinciples = !this.showPrinciples;
      this.showPoints = false;
    },
    togglePointsDisplay() {
      this.showPoints = !this.showPoints;
      this.showPrinciples = false;
    }
  }
};
</script>

<style scoped>
body {
  font-family: Arial, sans-serif;
  background-color: #22364B;
  padding-bottom: 100px;
}

.home-container {
  text-align: center;
  padding: 20px;
  color: #ecf0f1;
}

.gray-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.content-container {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.content-section {
  flex: 1;
  text-align: center;
  font-weight: bold;
  color : white;
}

.active {
  color: black;
}

.text-container {
  margin-top: 20px;
}

.text-content {
  padding: 20px;
  border-radius: 8px;
  background-color: white;
  color: #000000;
  margin-bottom: 50px;
  width: 600px;
}


.game-rules {
  font-size: 18px;
}

.game-rules li {
  margin-bottom: 10px;
  line-height: 1.6;
}

.game-rules p {
  font-size: 20px;
  margin-bottom: 10px;
  text-align: left;
}

</style>
