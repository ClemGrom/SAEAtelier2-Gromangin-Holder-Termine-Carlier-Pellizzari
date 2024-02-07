<template>
  <div class="container">
    <div class="login-form">
      <h2>Connexion</h2>
      <form @submit.prevent="loginUser">
        <div class="form-group">
          <label for="username">Email d'utilisateur:</label>
          <div class="input-group">
            <input v-model="email" type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            <i class="fas fa-user"></i>
          </div>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe:</label>
          <div class="input-group">
            <input v-model="password" type="password" id="password" name="password" placeholder="Mot de passe" required>
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <button type="submit">Se Connecter</button>
      </form>
      <p class="register-link">Pas encore de compte? <router-link to="/register">Inscrivez-vous ici</router-link></p>
    </div>
    <div class="back-link">
      <router-link to="/">Retourner à l'accueil</router-link>
    </div>
  </div>
</template>

<script>
import authService from '@/services/authService';
import router from '@/router';

export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async loginUser() {
      try {
        const credentials = {
          email: this.email,
          password: this.password,
        };
        authService.signIn(credentials).then((response) => {
          console.log('Utilisateur connecté:', response);
          router.push('/dashboard');
        });
      } catch (error) {
        console.error('Erreur lors de la connexion:', error.message);
      }
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

.login-form {
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

.input-group {
  position: relative;
}

.input-group input {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

.input-group i {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  color: #ccc;
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

.register-link {
  text-align: center;
  margin-top: 20px;
}

.back-link {
  margin-top: 20px;
}

.back-link a {
  color: #3498db;
  text-decoration: none;
  font-weight: bold;
}

.back-link a:hover {
  text-decoration: underline;
}

@media screen and (max-width: 768px) {
  .login-form {
    max-width: 300px;
  }
}
</style>
