<template>
  <div class="container">
    <h2>Connexion</h2>
    <form @submit.prevent="loginUser">
      <!-- Champs du formulaire -->
      <label for="username">Nom d'utilisateur:</label>
      <input v-model="username" type="text" id="username" name="username" required>

      <label for="password">Mot de passe:</label>
      <input v-model="password" type="password" id="password" name="password" required>

      <button type="submit">Se Connecter</button>

      <p>Pas encore de compte? <router-link to="/register">Inscrivez-vous ici</router-link></p>

      <router-link to="/" class="cta-button back-link">
        <span class="arrow">&larr;</span> Retour à l'accueil
      </router-link>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
    };
  },
  methods: {
    loginUser() {
      // TODO logique pour traiter la connexion (envoi au backend...)
      console.log('Utilisateur connecté:', this.username, this.password);
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

label {
  margin-bottom: 5px;
}

input {
  margin-bottom: 10px;
  padding: 8px;
  border: 1px solid #ccc;
}

.back-link {
  margin-top: 20px;
}

.back-link a {
  color: #3498db;
  text-decoration: underline;
  font-weight: bold;
}

.back-link a:hover {
  text-decoration: none;
}
</style>
