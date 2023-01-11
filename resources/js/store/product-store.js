import { createStore } from "vuex";
import axiosClient from "../axios";

const productStore = createStore({
    state: {
        products: {
            data: [],
            links: {},
            meta: {}
        },
        product: {
            data: {}
        },
        categories: {
            data: [],
            links: {},
            meta: {}
        },
        category: {
            data: {}
        },
        searchCategory: {
            data: []
        },
        coupons: {
            data: [],
            links: {},
            meta: {}
        },
        coupon: {
            data: {}
        },
    },
    getters: {},
    actions: {
        getProducts({ commit }, projectId) {
            return axiosClient.get(`/products/${projectId}`)
                .then(({data}) => {
                    commit('setProducts', data)
                    return data;
                })
        },
        searchProducts({ commit }, search) {
            return axiosClient.get(`/products/${search.projectId}?title=${search.title}`)
                .then(({data}) => {
                    commit('setProducts', data)
                    return data;
                })
        },
        paginateProducts({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setProducts', data)
                    return data;
                })
        },
        storeProduct({ }, payload) {
            return axiosClient.post(`/product/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        duplicateProduct({ }, id) {
            return axiosClient.post(`/product/duplicate/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getProduct({ commit }, id) {
            return axiosClient.get(`/product/show/${id}`)
                .then(({data}) => {
                    commit('setProduct', data)
                    return data;
                })
        },
        updateProduct({ }, payload) {
            return axiosClient.put(`/product/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteProduct({ }, id) {
            return axiosClient.delete(`/product/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getCatgories({ commit }, projectId) {
            return axiosClient.get(`/product/categories/${projectId}`)
                .then(({data}) => {
                    commit('setCategories', data)
                    return data;
                })
        },
        paginateCatgories({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setCategories', data)
                    return data;
                })
        },
        getCategory({ commit }, id) {
            return axiosClient.get(`/product/category/show/${id}`)
                .then(({data}) => {
                    commit('setCategory', data)
                    return data;
                })
        },
        searchCategory({ commit }, query) {
            return axiosClient.get(`/product/category/search/${query.projId}?category=${query.category}`)
                .then(({data}) => {
                    commit('setSearchCategory', data)
                    return data;
                })
        },
        updateCategory({ }, payload) {
            return axiosClient.put(`/product/category/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteCategory({ }, id) {
            return axiosClient.delete(`/product/category/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getCoupons({ commit }, projectId) {
            return axiosClient.get(`/product/coupons/${projectId}`)
                .then(({data}) => {
                    commit('setCoupons', data)
                    return data;
                })
        },
        paginateCoupons({ commit }, url) {
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setCoupons', data)
                    return data;
                })
        },
        getCoupon({ commit }, id) {
            return axiosClient.get(`/product/coupon/show/${id}`)
                .then(({data}) => {
                    commit('setCoupon', data)
                    return data;
                })
        },
        storeCoupon({ }, payload) {
            return axiosClient.post(`/product/coupon/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateCoupon({ }, payload) {
            return axiosClient.put(`/product/coupon/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteCoupon({ }, id) {
            return axiosClient.delete(`/product/coupon/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setProducts: (state, data) => {
            state.products = data
        },
        setProduct: (state, data) => {
            state.product = data
        },
        setCategories: (state, data) => {
            state.categories = data
        },
        setCategory: (state, data) => {
            state.category = data
        },
        setSearchCategory: (state, data) => {
            state.searchCategory = data
        },
        setCoupons: (state, data) => {
            state.coupons = data
        },
        setCoupon: (state, data) => {
            state.coupon = data
        },
    },
    modules: {}
});

export default productStore;