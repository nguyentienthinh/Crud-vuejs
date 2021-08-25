import HomeComponent from './components/HomeComponent.vue';
import CreateComponent from './components/CreateComponent.vue';
import IndexComponent from './components/IndexComponent.vue';
import EditComponent from './components/EditComponent.vue';

class route {
    getRoutes() {
        const routes = [{
                name: 'home',
                path: '/',
                component: HomeComponent
            },
            {
                name: 'create',
                path: '/posts/create',
                component: CreateComponent
            },
            {
                name: 'posts',
                path: '/posts',
                component: IndexComponent
            },
            {
                name: 'edit',
                path: '/posts/edit/:slug',
                component: EditComponent
            }
        ];

        return routes;
    }
}

export default new route();