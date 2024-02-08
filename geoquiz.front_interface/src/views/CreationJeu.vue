<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-custom">
    <div class="row w-100 text-white">
      <h2 class="main-title text-center rounded">Choix de la difficulté : </h2>
      <div class="col-lg-12 ">
        <div class="d-flex justify-content-around mt-5 text-dark ">
          <button class="btn text-white btn-no-hover" :class="{ 'bg-success': difficulty === 'easy' }"
                  @click="setDifficulty('easy')">Facile
          </button>
          <button class="btn text-white btn-no-hover" :class="{ 'bg-warning': difficulty === 'normal' }"
                  @click="setDifficulty('normal')">Normal
          </button>
          <button class="btn text-white btn-no-hover" :class="{ 'bg-danger': difficulty === 'hard' }"
                  @click="setDifficulty('hard')">Difficile
          </button>
        </div>
      </div>
      <div class="bg-white rounded">

        <div class="col-lg-12 bg-white text-dark">
          <h2 class="main-title text-center">Choix de la série</h2>
          <div class="mt-5 series-container row ">
            <div v-for="serie in this.infosSeries" :key="serie.id"
                 class="series-card col-lg-3 mb-2 bg-custom text-white rounded">
              <h3>{{ serie.nom }}</h3>
              <img :src="'http://docketu.iutnc.univ-lorraine.fr:50010/assets/' + serie.image+'/'+serie.nomImage" alt="Image de la série" class="img-fluid">
              <p>{{ serie.description }}</p>
              <p>Meilleur score : {{ serie.bestScore || '--' }}</p>
              <button class="btn btn-success" @click="getLieux(serie.id)">Choisir cette série</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

//
//Récupération des informations des séries et des lieux pour préparer la partie
//@author: Jules HOLDER
import axios from 'axios';


export default {
  data() {
    return {
      loading: true,
      errored: false,
      difficulty: 'easy',
      infosSeries: null,
      infosSeries_Lieux: null,
      infosLieux: null,
      apiClient: axios.create({
        withCredentials: false
      })
    };
  },
  methods: {
    setDifficulty(difficulty) {
      this.difficulty = difficulty;
    },
    createGame() {
      // Implémentez la logique de création de la partie ici
    },
    /**
     * Récupère les informations des séries de lieux via l'API REST de la BD Directus
     * @return: inutilisable
     */
    getSeries() {
      this.loading = true;
      this.apiClient.get('http://docketu.iutnc.univ-lorraine.fr:50010/items/Serie')
          .then(response => {
            this.infosSeries = response.data.data;
          })
          .catch(error => {
            console.log(error)
            this.errored = true
            this.loading = false
          })
          .finally(() => this.loading = false)
    },
    /**
     * Récupère les informations des lieux de la série via l'API REST de la BD Directus
     * Utilise la table relationnelle Serie_Lieu pour récupérer les lieux associés à la série
     * Stocke ensuite les informations des séries et lieux
     * @param {int} id - id de la série sélectionné précédemment
     * @return: inutilisable
     */
    getLieux(id) {
      this.loading = true;
      this.apiClient
          .get(`http://docketu.iutnc.univ-lorraine.fr:50010/items/Lieu_Serie?filter[Serie_id][_eq]=${id}`)
          .then(response => {
            this.infosSeries_Lieux = response.data.data;
            const lieux = [];
            for (let i = 0; i < this.infosSeries_Lieux.length; i++) {
              lieux.push(this.infosSeries_Lieux[i].Lieu_id);
            }
            this.apiClient.get('http://docketu.iutnc.univ-lorraine.fr:50010/items/Lieu?filter[id][_in]=' + lieux.join(','))
                .then(response => {
                  this.infosLieux = response.data;
                  const serieActuelle = this.infosSeries.find(serie => serie.id === id);
                  localStorage.setItem('infosSeries', JSON.stringify(serieActuelle));
                  localStorage.setItem('infosLieux', JSON.stringify(this.infosLieux));
                  this.$router.push('/jeu');
                })
                .catch(error => {
                  console.log(error)
                  this.errored = true
                  this.loading = false
                })
                .finally(() => this.loading = false);
          })
          .catch(error => {
            console.log(error)
            this.errored = true
            this.loading = false
          })
          .finally(() => this.loading = false);
    }
  },
  mounted() {
    this.getSeries();
  }
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
  