import axios from 'axios';

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
    }
};