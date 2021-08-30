import BaseService from './BaseService';
const uri = '/user';

class UserService extends BaseService {
    async login(params = {}) {
        const res = await this.post(uri + '/login', params);
        return res.data;
    }

    async register(params = {}) {
        const res = await this.post(uri + '/register', params);
        return res.data;
    }

    async logout(params = {}) {
        const res = await this.post(uri + '/logout', params);
        return res.data;
    }

    async getUser() {
        if (sessionStorage.getItem('access_token')) {
            const res = await this.get(uri + '/info');
            return res.data;
        }

        return false;
    }
}

export default new UserService();