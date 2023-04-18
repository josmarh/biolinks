import { createStore } from "vuex";
import axiosClient from "../axios";

const resellerStore = createStore({
    state: {
        users: {
            data: [],
            meta: {},
            links: {}
        },
        roles: {
            data: []
        }
    },
    getters: {},
    actions: {
        getUsers({ commit }, {url = null} = {}) {
            if(url) {
                if(url.includes('@'))
                    url = `/reseller/users?email=${url}`
                else
                    url = url
            }else {
                url = '/reseller/users'
            }

            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setUsers', data)
                    return data;
                })
        },
        storeUser({ }, payload) {
            return axiosClient.post(`/reseller/user`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateUser({ }, payload) {
            return axiosClient.put(`/reseller/user/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteUser({ }, id) {
            return axiosClient.delete(`/reseller/user/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getRoles({ commit }, ){
            return axiosClient.get('/roles')
                .then(({data}) => {
                    commit('setRoles', data)
                    return data;
                })
        },
        register({ }, payload) {
            return axiosClient.post(`/reseller/register`, payload)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setUsers: (state, data) => {
            state.users = data
        },
        setRoles: (state, data) => {
            state.roles = data
        },
    },
    modules: {}
});

export default resellerStore;