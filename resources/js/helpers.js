import store from "./store";
import adminStore from "./store/admin-store";
import { notify } from 'notiwind'

const helper = {
    applink: `${window.location.protocol}//${window.location.host}/`,
    getCountries() {
        store
            .dispatch('getCountries')
            .then((res) => {})
            .catch((err) => {
                let errMsg;
                if(err.response) {
                    if (err.response.data) {
                        if (err.response.data.hasOwnProperty("message"))
                            errMsg = err.response.data.message;
                        else
                            errMsg = err.response.data.error;
                    }
                }else{
                    errMsg = err;
                }
                notify({
                    group: "error",
                    title: "Error",
                    text: errMsg
                }, 4000);
            })
    },
    getLanguages() {
        store
            .dispatch('getLanguages')
            .then((res) => {})
            .catch((err) => {
                let errMsg;
                if(err.response) {
                    if (err.response.data) {
                        if (err.response.data.hasOwnProperty("message"))
                            errMsg = err.response.data.message;
                        else
                            errMsg = err.response.data.error;
                    }
                }else{
                    errMsg = err;
                }
                notify({
                    group: "error",
                    title: "Error",
                    text: errMsg
                }, 4000);
            })
    },
    getRoles() {
        adminStore
            .dispatch('getRoles')
            .then((res) => {})
            .catch((err) => {           
                if(err.response) {
                    if (err.response.data) {
                        let errMsg;
                        if (err.response.data.hasOwnProperty("message")) {
                            errMsg = err.response.data.message
                        } else {
                            errMsg = err.response.data.error
                        }
                        notify({
                            group: "error",
                            title: "Error",
                            text: errMsg
                        }, 4000)
                    }
                }
            })
    }
};

export default helper;