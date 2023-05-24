import axios from './axios';
import store from '@/store';

const authFunctions = {


    setAuthToken(token) {
        if (token) {
            // Apply authorization token to every request if logged in
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            // Store token in local storage
            localStorage.setItem('access_token', token);
        } else {
            // Delete auth header
            delete axios.defaults.headers.common['Authorization'];
            // Remove token from local storage
            localStorage.removeItem('access_token');
        }
    },

    setUser(user) {
        if (user) {
            this.setUserInStore(user);
            localStorage.setItem('user', JSON.stringify(user));
        } else {
            this.setUserInStore(null);
            localStorage.removeItem('user');
        }
    },

    checkAuth() {
        if (!this.getAuthToken()) {
            this.resetAuth();
            return false;
        } else {
            this.setAuthToken(this.getAuthToken());
        }

        if (this.getUser()) {
            return true
        }

        this.resetAuth();
        return false;
    },

    resetAuth() {
        this.setAuthToken(false);
        this.setUser(false);
    },

    getAuthToken() {
        const isAuthenticated = localStorage.getItem('access_token');
        return isAuthenticated;
    },

    getUser() {

        const userInStore = this.getUserFromStore();
        if (userInStore) {
            return userInStore;
        }

        const userInLocalStorage = localStorage.getItem('user');
        if (userInLocalStorage) {
            const parsedUser = JSON.parse(userInLocalStorage);

            this.setUserInStore(parsedUser);
            return parsedUser;
        }

        return null;
    },


    setUserInStore(user) {
        store.dispatch('setUser', user);
    },


    getUserFromStore() {
        return store.getters.getUser;
    },



}
export default authFunctions
