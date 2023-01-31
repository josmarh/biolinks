import { createStore } from "vuex";
import axiosClient from "../axios";

const leads = createStore({
    state: {
        leads: {
            data: []
        },
        projectTeams: {
            data: []
        },
        customerLeads: {
            data: [],
            meta: {},
            links: {}
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
        getProjectInfo({ commit }, projectId) {
            return axiosClient.get(`/project/show/${projectId}`)
                .then(({data}) => {
                    commit('setProjects', data)
                    return data;
                })
        },
        updateProject({}, payload) {
            return axiosClient.put(`/project/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        sendProjectinvitation({}, payload) {
            return axiosClient.post('/project/invitation', payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteProject({}, projectId) {
            return axiosClient.delete(`/project/delete/${projectId}`)
                .then(({data}) => {
                    return data;
                })
        },
        getInvitationInfo({}, id) {
            return axiosClient.get(`/project/invitation/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getProjectTeam({ commit }, projectId) {
            return axiosClient.get(`/project/${projectId}/team`)
                .then(({data}) => {
                    commit('setProjectTeam', data)
                    return data;
                })
        },
        deleteProjectMember({}, payload) {
            return axiosClient.delete(`/project/${payload.projectId}/member?id=${payload.memberUserId}`)
                .then(({data}) => {
                    return data;
                })
        },
        getCustomerLeads({ commit }, projectId) {
            return axiosClient.get(`/project/${projectId}/customers`)
                .then(({data}) => {
                    commit('setCustomerLeads', data)
                    return data;
                })
        },
        
        exportCustomerLeads({ }, leads) {
            return axiosClient.post(`/project/${leads.projectId}/customer-export`, leads)
                .then(({data}) => {
                    return data;
                })
        },
        getCustomerLeadsPag({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setCustomerLeads', data)
                    return data;
                })
        },

        searchCustomerLeads({ commit } , payload) {

            return axiosClient.post(`/prospects/search`)
                .then((data => {
                    console.log(data);
                    return data;
                }));
        },
    },
    mutations: {
        setProjects: (state, data) => {
            state.projects = data;
        },
        setProjectTeam: (state, data) => {
            state.projectTeams = data;
        },
        setCustomerLeads: (state, data) => {
            state.customerLeads = data
        }
    },
    modules: {}
});

export default leads;