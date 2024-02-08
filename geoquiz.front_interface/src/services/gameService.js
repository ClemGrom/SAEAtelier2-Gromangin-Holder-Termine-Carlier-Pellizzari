import axios from 'axios';
import authService from './authService';

const apiPort = 50015;
const baseURL = `http://${window.location.hostname}:${apiPort}/api`;

const apiClient = axios.create({
    baseURL: baseURL,
    withCredentials: false,
});

export default {
    async getDifficulties() {
        try {
            const response = await apiClient.get('/difficulties', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') || '',
                }
            });
            //set localStorage.setItem
            localStorage.setItem('difficulties', JSON.stringify(response.data.difficulties));
            return response.data.difficulties;
        } catch (error) {
            throw new Error('Erreur lors de la récupération des difficultés');
        }
    },

    async createGame(gameData) {
        try {
            const response = await apiClient.post('/games', gameData);
            return response.data;
        } catch (error) {
            throw new Error('Erreur lors de la création du jeu');
        }
    },

    async getGameDetails(gameId) {
        try {
            const response = await apiClient.get(`/games/${gameId}`);
            return response.data;
        } catch (error) {
            throw new Error('Erreur lors de la récupération des détails du jeu');
        }
    },

    async submitGameResults(gameId, resultsData) {
        try {
            const response = await apiClient.post(`/games/${gameId}/submit`, resultsData);
            return response.data;
        } catch (error) {
            throw new Error('Erreur lors de la soumission des résultats du jeu');
        }
    },

    async getUserGames(userId) {
        try {
            const response = await apiClient.get(`/users/${userId}/games`);
            return response.data;
        } catch (error) {
            throw new Error('Erreur lors de la récupération des jeux de l\'utilisateur');
        }
    },

    async updateUserProfile(profileData) {
        try {
            const response = await apiClient.post('/users/profile', profileData);
            return response.data;
        } catch (error) {
            throw new Error('Erreur lors de la mise à jour du profil de l\'utilisateur');
        }
    },

    async checkAndRefreshToken() {
        const token = localStorage.getItem('token');
        const refreshToken = localStorage.getItem('refreshToken');

        if (token && refreshToken) {
            try{
                // Check if the token is still valid locally
                const tokenData = JSON.parse(atob(token.split('.')[1]));
                const expirationTime = tokenData.exp * 1000;
                const currentTime = Date.now();
                // If the token is still valid, do nothing and return the token
                if (expirationTime > currentTime) {
                    console.log('Token is still valid');
                    console.log('Remaining time:', expirationTime - currentTime);
                    return token;
                } else {
                    console.log('Token is expired');
                    // If the token is expired, try to get a new one from the refresh token
                    return await authService.getNewTokenFromRefreshToken();
                }
            } catch (error) {
                console.error('Erreur lors de la vérification et du renouvellement du token :', error.message)
            }
        }
    }
};