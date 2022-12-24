import { createStore } from "vuex";
import axiosClient from "../axios";

const reportStore = createStore({
    state: {
        dashboardCards: {
            totalVisits: 0,
            totalLinks: 0,
            totalLeads: 0
        }
    },
    getters: {},
    actions: {
        getDashboardReport({ commit }, ){
            return axiosClient.get('/report/dashbord-cards')
                .then(({data}) => {
                    commit('setDashboardCards', data)
                    return data;
                })
        },
    },
    mutations: {
        setDashboardCards: (state, data) => {
            state.dashboardCards = data
        }
    },
    modules: {}
});

export default reportStore;