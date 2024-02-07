<template>
  <div class="container">
    <h2>Connexion</h2>
    <form @submit.prevent="loginUser">
      <label for="username">Nom d'utilisateur:</label>
      <input v-model="username" type="text" id="username" name="username" required>

      <label for="password">Mot de passe:</label>
      <input v-model="password" type="password" id="password" name="password" required>

      <button type="submit">Se Connecter</button>

      <p>Pas encore de compte? <router-link to="/register">Inscrivez-vous ici</router-link></p>

      <router-link to="/" class="back-link">
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
  text-align: center;
  padding: 20px;
}

form {
  width: 100%;
}

label {
  margin-bottom: 10px;
}

input {
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 100%;
}

button:hover {
  background-color: #45a049;
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
