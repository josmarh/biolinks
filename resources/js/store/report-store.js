import { createStore } from "vuex";
import axiosClient from "../axios";

const reportStore = createStore({
    state: {
        dashboardCards: {
            totalVisits: 0,
            totalLinks: 0,
            totalLeads: 0
        },
        projectLinkClicks: {
            linkClicks: []
        },
        leads: {
            data: [],
            links: {},
            meta: {}
        },
        totalLeads: {
            totalLeads: 0
        }
    },
    getters: {},
    actions: {
        getDashboardReport({ commit }) {
            return axiosClient.get('/report/dashbord-cards')
                .then(({data}) => {
                    commit('setDashboardCards', data)
                    return data;
                })
        },
        getProjectLinkClicksReport({ commit }, projectId) {
            return axiosClient.get(`/report/project-links/${projectId}`)
                .then(({data}) => {
                    commit('setProjectLinkClicksReport', data)
                    return data;
                })
        },
        getLeadsReport({ commit }, params) {
            return axiosClient.get(`/report/leads/${params.id}?from=${params.from}&to=${params.to}`)
                .then(({data}) => {
                    commit('setLeads', data)
                    return data;
                })
        },
        getLeadsReportPag({ commit }, {url = null} = {}) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setLeads', data)
                    return data;
                })
        },
        getTotalLeadsReport({ commit }, linkId) {
            return axiosClient.get(`/report/leads/total/${linkId}`)
                .then(({data}) => {
                    commit('setTotalLeads', data)
                    return data;
                })
        },
        getPageViewReport({ commit }, params) {
            return axiosClient.get(`/report/page-view/${params.id}?from=${params.from}&to=${params.to}`)
                .then(({data}) => {
                    commit('setProjectLinkClicksReport', data)
                    return data;
                })
        },
        exportLeads({ }, leads) {
            return axiosClient.post(`/report/export-leads`, leads)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setDashboardCards: (state, data) => {
            state.dashboardCards = data
        },
        setProjectLinkClicksReport: (state, data) => {
            state.projectLinkClicks = data
        },
        setLeads: (state, data) => {
            state.leads = data
        },
        setTotalLeads: (state, data) => {
            state.totalLeads = data
        }
    },
    modules: {}
});

export default reportStore;