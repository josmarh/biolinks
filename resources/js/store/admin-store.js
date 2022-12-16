import { createStore } from "vuex";
import axiosClient from "../axios";

const adminStore = createStore({
    state: {
        users: {
            data: [],
            meta: {},
            links: {}
        },
        authGuard: {
            data: [],
            meta: {},
            links: {}
        },
        logs: {
            data: [],
            meta: {},
            links: {}
        },
        projects: {
            data: [],
            meta: {},
            links: {}
        },
    },
    getters: {},
    actions: {
        getUsers({ commit }, {url = null} = {}) {
            if(url) {
                if(url.includes('@'))
                    url = `/users?email=${url}`
                else
                    url = url
            }else {
                url = '/users'
            }

            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setUsers', data)
                    return data;
                })
        },
        storeUser({ }, payload) {
            return axiosClient.post(`/user`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateUser({ }, payload) {
            return axiosClient.put(`/user/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteUser({ }, id) {
            return axiosClient.delete(`/user/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getRoles({ commit }, {url = null} = {}){
            url = url || '/roles'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setAuthGuard', data)
                    return data;
                })
        },
        storeRole({ }, payload){
            return axiosClient.post(`/role`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateRole({ }, payload){
            return axiosClient.put(`/role/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteRole({ }, id){
            return axiosClient.delete(`/role/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getPermissions({ commit }, {url = null} = {}){
            url = url || '/permissions'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setAuthGuard', data)
                    return data;
                })
        },
        storePermission({ }, payload){
            return axiosClient.post(`/permission`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updatePermission({ }, payload){
            return axiosClient.put(`/permission/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deletePermission({ }, id){
            return axiosClient.delete(`/permission/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getRolePermissions({ }, id){
            return axiosClient.get(`/role-permission/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        assignPermissionsToRole({ }, payload){
            return axiosClient.post(`/assign-permissions`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getLoginHistory({ commit }, {url = null} = {}){
            if(url) {
                if(url.includes('@'))
                    url = `/admin/login-history?email=${url}`
                else
                    url = url
            }else {
                url = '/admin/login-history'
            }

            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setLogs', data)
                    return data;
                })
        },
        getProjects({ commit }, url){
            if(url) {
                if(typeof(url) == 'object') {
                    url = `/admin/projects?email=${url.email}&name=${url.name}`
                }else {
                    url = url
                }
            }else {
                url = '/admin/projects'
            }

            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setProjects', data)
                    return data;
                })
        },
        getProjectLinks({ commit }, url){
            if(url) {
                if(typeof(url) == 'object') {
                    url = `/admin/project-links?type=${url.type}&linkId=${url.linkId}`
                }else {
                    url = url
                }
            }else {
                url = '/admin/project-links'
            }

            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setProjects', data)
                    return data;
                })
        },
    },
    mutations: {
        setUsers: (state, data) => {
            state.users = data
        },
        setAuthGuard: (state, data) => {
            state.authGuard = data
        },
        setLogs: (state, data) => {
            state.logs = data
        },
        setProjects: (state, data) => {
            state.projects = data
        }
    },
    modules: {}
});

export default adminStore;