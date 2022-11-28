import store from "./store";
import { notify } from 'notiwind'

const helper = {
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
    }
};

export default helper;