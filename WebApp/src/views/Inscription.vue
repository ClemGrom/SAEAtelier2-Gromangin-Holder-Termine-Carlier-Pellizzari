<template>
  <div class="container">
    <h2>Inscription</h2>
    <form @submit.prevent="registerUser">
      <label for="username">Nom d'utilisateur:</label>
      <input v-model="username" type="text" id="username" name="username" required>

      <label for="email">Email:</label>
      <input v-model="email" type="email" id="email" name="email" required>

      <label for="password">Mot de passe:</label>
      <input v-model="password" type="password" id="password" name="password" required>

      <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà membre? <router-link to="/login">Connectez-vous ici</router-link></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      email: '',
      password: '',
    };
  },
  methods: {
    registerUser() {
      // logique pour traiter l'inscription (envoi au backend...)
      console.log('Utilisateur inscrit:', this.username, this.email, this.password);
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
</style>
