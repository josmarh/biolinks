import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(localStorage.getItem('userInfo')),
            token: localStorage.getItem('TOKEN'),
            permissions: localStorage.getItem('can'),
        },
        countries: [],
        languages: [],
    },
    getters: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post('/register', user)
                .then(({data}) => {
                    commit('setUser', data)
                    return data;
                })
        },
        login({ commit }, user) {
            return axiosClient.post('/login', user)
                .then(({data}) => {
                    commit('setUser', data)
                    return data;
                })
        },
        updateProfile({ commit }, user) {
            return axiosClient.put(`/profile/update`, user)
            .then(({data}) => {
                commit('updateProfile', data)
                return data;
            })
        },
        updatePassword({ }, userPass) {
            return axiosClient.put(`/password/update`, userPass)
                .then(({data}) => {
                    return data;
                })
        },
        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(response => {
                    commit('logout')
                    return response;
                })
        },
        forgotPassword({ }, user) {
            return axiosClient.post('/forgot-password', user)
                .then(({data}) => {
                    return data;
                })
        },
        resetPassword({ }, user) {
            return axiosClient.post('/reset-password', user)
                .then(({data}) => {
                    return data;
                })
        },
        getCountries({ commit }) {
            return axiosClient.get('/countries')
                .then(({data}) => {
                    commit('setCountries', data)
                    return data;
                })
        },
        getLanguages({ commit }) {
            return axiosClient.get('/languages')
                .then(({data}) => {
                    commit('setLanguages', data)
                    return data;
                })
        },
    },
    mutations: {
        setUser: (state, userData) => {
            state.user.data = userData.user
            state.user.token = userData.token
            state.user.permissions = userData.permissions
            localStorage.setItem('userInfo', JSON.stringify(userData.user));
            localStorage.setItem('TOKEN', userData.token);
            localStorage.setItem('can', userData.permissions);
        },
        updateProfile: (state, userInfo) => {
            state.user.data = userData.user
            localStorage.setItem('userInfo', JSON.stringify(userInfo.user));
        },
        logout: (state, userInfo) => {
            state.user = null;
            localStorage.clear();
        },
        setCountries: (state, data) => {
            state.countries = data;
        },
        setLanguages: (state, data) => {
            state.languages = data;
        },
    },
    modules: {}
   
});

export default store;