import axios from 'axios'
import Vue from 'vue'

const domain = process.env.MIX_APP_API_URL_PUBLIC;
const accessToken = (sessionStorage.getItem('access_token')) ? sessionStorage.getItem('access_token') : null;

export default class BaseService {
    async get(uri, params = {}) {
        try {
            return await axios.get(
                domain + uri, {
                    params: params,
                    headers: { "Authorization": `Bearer ` + accessToken }
                }
            )
        } catch (e) {
            return this.errorMsg(e)
        }
    }

    async post(uri, params = {}) {
        try {
            return await axios.post(
                domain + uri,
                params, { headers: { "Authorization": `Bearer ` + accessToken } }
            )
        } catch (e) {
            return this.errorMsg(e)
        }
    }

    async put(uri, params = {}) {
        try {
            return await axios.put(
                domain + uri,
                params, { headers: { "Authorization": `Bearer ` + accessToken } }
            )
        } catch (e) {
            return this.errorMsg(e)
        }
    }

    async show(uri) {
        try {
            return await axios.get(domain + uri)
        } catch (e) {
            return this.errorMsg(e)
        }
    }

    async delete(uri) {
        try {
            return await axios.delete(domain + uri, {
                headers: { "Authorization": `Bearer ` + accessToken }
            })
        } catch (e) {
            return this.errorMsg(e)
        }
    }

    errorMsg(e) {
        if (e.response === undefined) {
            e.status = 0
            e.statusText = e.message
            return { data: e }
        }

        let validationErrors = ''
        if (e.response.status === 422) {
            const errors = e.response.data.errors
            for (let key in errors) {
                validationErrors += errors[key] + '. '
            }
        } else if (e.response.status === 401) {
            // Notify
            var notify = $.notify('No Authentication!', {
                type: 'danger',
                allow_dismiss: true,
            });
        } else {
            validationErrors = e.response.data
        }

        Vue.$notify('error', e.response.statusText, validationErrors, { duration: 5000, permanent: false })

        return { data: e.response }
    }
}