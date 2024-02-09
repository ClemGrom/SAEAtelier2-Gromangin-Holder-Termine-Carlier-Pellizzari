import axios from 'axios';

const apiPort = 50015;
const baseURL = `http://${window.location.hostname}:${apiPort}/api`;

const apiClient = axios.create({
    baseURL: baseURL,
    withCredentials: false,
});

export default {
    async signUp(userData) {
        try {

            const response = await apiClient.post('/users/signup', userData);
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('refreshToken', response.data.refreshToken);
            return response.data;
        } catch (error) {
            if (error.response && error.response.data && error.response.data.error) {
                throw new Error(error.response.data.error);
            } else {
                throw new Error(`Erreur lors de l'inscription: ${error.message}`);
            }
        }
    },

    async signIn(credentials) {
        try {
            const response = await apiClient.post('/users/signin', null, {
                headers: {
                    "Authorization": "Basic " + btoa(credentials.email + ":" + credentials.password),
                }
            });
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('refreshToken', response.data.refreshToken);
            return response.data;
        } catch (error) {
            if (error.response && error.response.data && error.response.data.error) {
                throw new Error(error.response.data.error);
            } else {
                throw new Error('Erreur lors de la connexion');
            }
        }
    },

    async getNewTokenFromRefreshToken() {
        try {
            const refreshToken = localStorage.getItem('refreshToken');
            if(!refreshToken){
                throw new Error('No refresh token found');
            }
            const response = await apiClient.post('/users/refresh', null, {
                headers: {
                    "Authorization": `Bearer ${refreshToken}`
                }
            });
            const newToken = response.data.token;
            const newRefreshToken = response.data.refreshToken;
            console.log('newToken', newToken);
            console.log('newRefreshToken', newRefreshToken);

            localStorage.setItem('token', newToken);
            localStorage.setItem('refreshToken', newRefreshToken);
            return newToken;
        } catch (error) {
            throw new Error('Erreur lors de la récupération du nouveau token');
        }
    },

};