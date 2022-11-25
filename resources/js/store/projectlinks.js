import { createStore } from "vuex";
import axiosClient from "../axios";

const projectlinks = createStore({
    state: {
        links: {
            data: [],
            meta: {},
            link: {}
        },
    },
    getters: {},
    actions: {
        getLinks({ commit }, pid) {
            return axiosClient.get(`/links?pid=${pid}`)
                .then(({data}) => {
                    commit('setLinks', data)
                    return data;
                })
        },
        storeLink({}, payload) {
            return axiosClient.post('/link/store', payload)
                .then(({data}) => {
                    return data;
                })
        },
        getLinkInfo({ commit }, linkId) {
            return axiosClient.get(`/link/show/${linkId}`)
                .then(({data}) => {
                    commit('setLinks', data)
                    return data;
                })
        },
        getLinkInfoId({ commit }, id) {
            return axiosClient.get(`/link/edit/${id}`)
                .then(({data}) => {
                    commit('setLinks', data)
                    return data;
                })
        },
        updateLinkStatus({}, payload) {
            return axiosClient.put(`/link/update/status/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        duplicateLink({}, id) {
            return axiosClient.post(`/link/duplicate/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        deleteLink({}, id) {
            return axiosClient.delete(`/link/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setLinks: (state, data) => {
            state.links = data;
        },
    },
    modules: {}
});

export default projectlinks;