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
        blog: {
            data: {}
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
    },
    modules: {}
});

export default memberStore;