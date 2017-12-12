export default class Request {
    static sendRequest(config) {
        config.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + Vue.cookie.get('token'),
            'language': Vue.locale
        };
        return new Promise((resolve, reject) => {
            axios.request(config)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data.errors);
                });
        });
    }

    static get(url, params) {
        let config = {
            method: 'get',
            baseURL: $baseUrl,
            url: url,
            params: params
        };
        return this.sendRequest(config);
    }

    static post(url, data) {
        let config = {
            method: 'post',
            url: url,
            baseURL: $baseUrl,
            data: data
        };
        return this.sendRequest(config);
    }

    static put(url, data) {
        let config = {
            method: 'put',
            url: url,
            baseURL: $baseUrl,
            data: data
        };
        return this.sendRequest(config);
    }

    static delete(url, params) {
        let config = {
            method: 'delete',
            url: url,
            baseURL: $baseUrl,
            params: params
        };
        return this.sendRequest(config);
    }
}
