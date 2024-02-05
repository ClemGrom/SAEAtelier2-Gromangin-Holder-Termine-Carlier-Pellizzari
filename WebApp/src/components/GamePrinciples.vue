<template>
  <div>
    <div class="game">
          <h2 class="section-title">Principe et règles du jeu</h2>
  
    <p class="game-description">
      GeoQuizz est un jeu captivant où votre tâche est de placer avec précision des photos sur une carte de votre ville, plus rapidement que les autres joueurs. Voici comment le jeu fonctionne :
    </p>

    <ul class="game-rules">
      <li>Une partie consiste en une séquence de 10 photos aléatoires d'une même série, à placer sur la carte de la ville.</li>
      <li>Chaque série regroupe des photos de la même ville et de la même carte.</li>
      <li>Vous gagnez des points en fonction de la précision du placement et de la rapidité de votre réponse.</li>
      <li>L'objectif est d'obtenir le maximum de points au cours d'une partie de 10 photos.</li>
      <li>La partie se termine une fois que toutes les 10 photos ont été positionnées.</li>
    </ul>
  </div>

  <div class="scoring">
    <h3 class="scoring-title">Règles de calcul des points :</h3>
    <ul class="scoring-rules">
      <li>Pour une réponse placée à une distance inférieure à D : 5 points.</li>
      <li>Pour une réponse placée à une distance inférieure à 2D : 3 points.</li>
      <li>Pour une réponse placée à une distance inférieure à 3D : 1 point.</li>
      <li>Les points sont multipliés par 4 pour une réponse en moins de 5 secondes.</li>
      <li>Les points sont multipliés par 2 pour une réponse en moins de 10 secondes.</li>
      <li>Aucun point n'est acquis pour une réponse en plus de 20 secondes.</li>
    </ul>
  </div>
  </div>
</template>

<script>
export default {
  // TODO ajouter des propriétés ou des méthodes spécifiques au composant ici
};
</script>

<style scoped>
div{
  display: grid;
  grid-template-columns: 12 1fr 1fr;
  grid-gap: 20px;
  color: black;
  
}
.game{
  grid-column: 1/5;
  background-color: white;
  padding: 20px;
  border-radius: 20px;
}
.scoring{
  grid-column: 5/13;
  background-color: white;
  padding: 20px;
  border-radius: 20px;
}
.game-description {
  font-size: 16px;
 
}

.section-title {
  font-size: 24px;
  color: black;

  font-weight: bold;
  text-decoration: underline;

}

.game-rules {
  font-size: 14px;
 
  margin-left: 20px;
  list-style: none;
}

.scoring-title {
  font-size: 20px;
  
 
  text-decoration: underline;
}

.scoring-rules {
  font-size: 14px;

  list-style: none;
}
</style>
