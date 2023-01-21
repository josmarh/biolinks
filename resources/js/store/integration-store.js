import { createStore } from "vuex";
import axiosClient from "../axios";

const integrationStore = createStore({
    state: {
        payment: {
            data: {}
        },
        esp: {
            data: {}
        }
    },
    getters: {},
    actions: {
        getPayment({ commit }, projectId) {
            return axiosClient.get(`/integration/payment/show/${projectId}`)
                .then(({data}) => {
                    commit('setPayment', data)
                    return data;
                })
        },
        upatePayment({  }, payload) {
            return axiosClient.post(`/integration/payment/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getEsp({ commit }, projectId) {
            return axiosClient.get(`/integration/esp/show/${projectId}`)
                .then(({data}) => {
                    commit('setEsp', data)
                    return data;
                })
        },
        upateEsp({  }, payload) {
            return axiosClient.post(`/integration/esp/store`, payload)
                .then(({data}) => {
                    return data;
                })
        }
    },
    mutations: {
        setPayment: (state, data) => {
            state.payment = data
        },
        setEsp: (state, data) => {
            state.esp = data
        },
    },
    modules: {}
});

export default integrationStore;