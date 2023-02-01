import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(localStorage.getItem('userInfo')),
            token: localStorage.getItem('TOKEN'),
            permissions: localStorage.getItem('can'),
            membership: localStorage.getItem('membership'),
        },
        countries: [],
        languages: [],
        loginHistory: {
            data: [],
            meta: {},
            links: {}
        }
    },
    getters: {},
    actions: {
        register({ }, user) {
            return axiosClient.post('/register', user)
                .then(({data}) => {
                    return data;
                })
        },
        registerMember({ }, user) {
            return axiosClient.post(`/register/${user.invitationId}`, user)
                .then(({data}) => {
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
        updateAccount({ commit }, user) {
            return axiosClient.put(`/account/update`, user)
            .then(({data}) => {
                commit('updateProfile', data)
                return data;
            })
        },
        updateKey({ commit }, key) {
            return axiosClient.put(`/api-key/update`, key)
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
                    localStorage.clear();
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
        getLoginHistory({ commit }, email) {
            return axiosClient.get(`/user-logs/${email}`)
                .then(({data}) => {
                    commit('setLoginHistory', data)
                    return data;
                })
        },
        getLoginHistoryPage({ commit }, {url = null} = {}) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setLoginHistory', data)
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
            localStorage.setItem('membership', userData.membership[0]);
        },
        updateProfile: (state, userData) => {
            state.user.data = userData.user
            localStorage.setItem('userInfo', JSON.stringify(userData.user));
        },
        logout: state => {
            state.user.data = {};
            state.user.token = null;
        },
        setCountries: (state, data) => {
            state.countries = data;
        },
        setLanguages: (state, data) => {
            state.languages = data;
        },
        setLoginHistory: (state, data) => {
            state.loginHistory = data;
        },
    },
    modules: {}
   
});

export default store;