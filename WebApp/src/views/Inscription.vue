<template>
  <div class="container">
    <div class="registration-form">
      <h2>Inscription</h2>
      <form @submit.prevent="registerUser">
        <div class="form-group">
          <label for="username">Nom d'utilisateur:</label>
          <input v-model="username" type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input v-model="email" type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe:</label>
          <input v-model="password" type="password" id="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button type="submit">S'inscrire</button>
      </form>
      <p class="login-link">Déjà membre? <router-link to="/login">Connectez-vous ici</router-link></p>
    </div>
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
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  height: 100vh;
}

.registration-form {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  background-color: #f4f7f6;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

input {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 100%;
}

button:hover {
  background-color: #45a049;
}

.login-link {
  text-align: center;
  margin-top: 20px;
}

.login-link a {
  color: #3498db;
  text-decoration: none;
  font-weight: bold;
}

.login-link a:hover {
  text-decoration: underline;
}

@media screen and (max-width: 768px) {
  .registration-form {
    max-width: 300px;
  }
}
</style>
