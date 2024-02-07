import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://geoquiz-gateway/api',
    withCredentials: true,
});

export default {
    async signUp(userData) {
        try {
            const response = await apiClient.post('/users/signup', userData);
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('refreshToken', response.data.refreshToken);
            return response.data;
        } catch (error) {
            throw new Error(error.response.data.message || 'Erreur lors de l\'inscription');
        }
    },

    async signIn(credentials) {
        try {
            const response = await apiClient.post('/users/signin', credentials);
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('refreshToken', response.data.refreshToken);
            return response.data;
        } catch (error) {
            throw new Error(error.response.data.error || 'Erreur lors de la connexion');
        }
    }
};
