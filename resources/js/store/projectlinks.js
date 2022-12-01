import { createStore } from "vuex";
import axiosClient from "../axios";

const projectlinks = createStore({
    state: {
        links: {
            data: [],
            meta: {},
            link: {}
        },
        linkSettings: {
            data: []
        },
        biolinkSettings: {
            data: {}
        },
        biolinkCustomSettings: {
            data: {}
        }
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
        updateLinkSettings({}, payload) {
            return axiosClient.put(`/link/update/link/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateBiolinkSettings({}, payload) {
            return axiosClient.put(`/link/update/biolink/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getLinkSettings({ commit }, id) {
            return axiosClient.get(`/link/link/${id}`)
                .then(({data}) => {
                    commit('setLinkSettings', data)
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
        getBiolinkSettings({ commit }, id) {
            return axiosClient.get(`/link/biolink/settings/${id}`)
                .then(({data}) => {
                    commit('setBiolinkSettings', data)
                    return data;
                })
        },
        updateBiolinkSettings({ }, payload) {
            return axiosClient.put(`/link/biolink/settings/${payload.linkId}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getBiolinkCustomSettings({ commit }, id) {
            return axiosClient.get(`/link/biolink/custom/${id}`)
                .then(({data}) => {
                    commit('setBiolinkCustomSettings', data)
                    return data;
                })
        },
        updateBiolinkCustomSettings({ }, payload) {
            return axiosClient.put(`/link/biolink/custom/${payload.linkId}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setLinks: (state, data) => {
            state.links = data;
        },
        setLinkSettings: (state, data) => {
            state.linkSettings = data;
        },
        setBiolinkSettings: (state, data) => {
            state.biolinkSettings = data;
        },
        setBiolinkCustomSettings: (state, data) => {
            state.biolinkCustomSettings = data;
        },
    },
    modules: {}
});

export default projectlinks;