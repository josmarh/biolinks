import { createStore } from "vuex";
import axiosClient from "../axios";

const biolinksection = createStore({
    state: {
        section: {
            data: []
        }
    },
    getters: {},
    actions: {
        getSections({ commit }, id) {
            return axiosClient.get(`/link/biolink/sections/${id}`)
                .then(({data}) => {
                    commit('setSections', data);
                    return data;
                })
        },
        storeSection({}, payload) {
            return axiosClient.post('/link/biolink/section', payload)
                .then(({data}) => {
                    return data;
                })
        },
        showSection({}, id) {
            return axiosClient.get(`/link/biolink/section/${id}`)
                .then(({data}) => {
                    commit('setSections', data);
                    return data;
                })
        },
        updateSection({}, payload) {
            return axiosClient.put(`/link/biolink/section/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteSections({}, id) {
            return axiosClient.delete(`/link/biolink/section/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setSections: (state, data) => {
            state.section = data;
        },
    },
    modules: {}
});

export default biolinksection;