import BaseService from './BaseService';
const uri = '/posts';

class PostService extends BaseService {
    async index(params = {}) {
        const res = await this.get(uri, params)
        return res.data
    }

    async create(params = {}) {
        const res = await this.post(uri + '/create', params)
        return res.data
    }

    async edit(slug, params = {}) {
        const res = await this.get(uri + `/edit/${slug}`, params)
        return res.data
    }

    async update(slug, params = {}) {
        const res = await this.put(uri + `/update/${slug}`, params)
        return res.data
    }

    async destroy(slug) {
        const res = await this.delete(uri + `/${slug}`)
        return res.data
    }
}

export default new PostService();