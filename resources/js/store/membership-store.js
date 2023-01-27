import { createStore } from "vuex";
import axiosClient from "../axios";

const memberStore = createStore({
    state: {
        posts: {
            data: [],
            links: {},
            meta: {}
        },
        post: {
            data: {}
        },
        plans: {
            data: [],
            links: {},
            meta: {}
        },
        plan: {
            data: {}
        },
        blog: {
            data: {}
        },
        subscribers: {
            data: [],
            links: {},
            meta: {}
        }
    },
    getters: {},
    actions: {
        getPosts({ commit }, projectId) {
            return axiosClient.get(`/membership/posts/${projectId}`)
                .then(({data}) => {
                    commit('setPosts', data)
                    return data;
                })
        },
        searchPosts({ commit }, search) {
            return axiosClient.get(`/membership/posts/${search.projectId}?title=${search.title}`)
                .then(({data}) => {
                    commit('setPosts', data)
                    return data;
                })
        },
        paginatePosts({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setPosts', data)
                    return data;
                })
        },
        storePost({ }, payload) {
            return axiosClient.post(`/membership/post/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        duplicatePost({ }, id) {
            return axiosClient.post(`/membership/post/duplicate/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getPost({ commit }, id) {
            return axiosClient.get(`/membership/post/show/${id}`)
                .then(({data}) => {
                    commit('setPost', data)
                    return data;
                })
        },
        updatePost({ }, payload) {
            return axiosClient.put(`/membership/post/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deletePost({ }, id) {
            return axiosClient.delete(`/membership/post/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getBlog({ commit }, projectId) {
            return axiosClient.get(`/membership/blog/show/${projectId}`)
                .then(({data}) => {
                    commit('setBlog', data)
                    return data;
                })
        },
        storeBlog({ }, payload) {
            return axiosClient.post(`/membership/blog/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getPlans({ commit }, projectId) {
            return axiosClient.get(`/membership/plans/${projectId}`)
                .then(({data}) => {
                    commit('setPlans', data)
                    return data;
                })
        },
        searchPlans({ commit }, search) {
            return axiosClient.get(`/membership/plans/${search.projectId}?title=${search.title}`)
                .then(({data}) => {
                    commit('setPlans', data)
                    return data;
                })
        },
        paginatePlans({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setPlans', data)
                    return data;
                })
        },
        storePlan({ }, payload) {
            return axiosClient.post(`/membership/plan/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getPlan({ commit }, id) {
            return axiosClient.get(`/membership/plan/show/${id}`)
                .then(({data}) => {
                    commit('setPlan', data)
                    return data;
                })
        },
        updatePlan({ }, payload) {
            return axiosClient.put(`/membership/plan/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deletePlan({ }, id) {
            return axiosClient.delete(`/membership/plan/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getSubscribers({ commit }, projectId) {
            return axiosClient.get(`/membership/subscribers/${projectId}/list`)
                .then(({data}) => {
                    commit('setSubscribers', data)
                    return data;
                })
        },
        removeSubscriber({ }, payload) {
            return axiosClient.put(`/membership/subscribers/${payload.projectId}/remove`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        paginateSubscribers({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setSubscribers', data)
                    return data;
                })
        },
    },
    mutations: {
        setPosts: (state, data) => {
            state.posts = data
        },
        setPost: (state, data) => {
            state.post = data
        },
        setBlog: (state, data) => {
            state.blog = data
        },
        setPlans: (state, data) => {
            state.plans = data
        },
        setPlan: (state, data) => {
            state.plan = data
        },
        setSubscribers: (state, data) => {
            state.subscribers = data
        },
    },
    modules: {}
});

export default memberStore;