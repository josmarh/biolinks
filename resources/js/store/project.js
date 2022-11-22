import { createStore } from "vuex";
import axiosClient from "../axios";

const project = createStore({
    state: {
        projects: {
            data: []
        }
    },
    getters: {},
    actions: {
        getProjects({ commit }) {
            return axiosClient.get('/projects')
                .then(({data}) => {
                    commit('setProjects', data)
                    return data;
                })
        },
        storeProject({}, payload) {
            return axiosClient.post('/project/store', payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateProject({}, payload) {
            return axiosClient.put(`/project/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setProjects: (state, data) => {
            state.projects = data;
        },
    },
    modules: {}
});

export default project;