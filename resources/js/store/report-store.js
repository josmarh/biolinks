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
        getPageViewReport({ commit }, linkId) {
            return axiosClient.get(`/report/page-view/${linkId}`)
                .then(({data}) => {
                    commit('setProjectLinkClicksReport', data)
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
        }
    },
    modules: {}
});

export default reportStore;