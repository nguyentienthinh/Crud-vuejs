import HomeComponent from './components/HomeComponent.vue';
import UserComponent from './components/UserComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import CreateComponent from './components/CreateComponent.vue';
import IndexComponent from './components/IndexComponent.vue';
import EditComponent from './components/EditComponent.vue';
import PageNotFoundComponent from './components/PageNotFoundComponent.vue';

class route {
    getRoutes() {
        const routes = [{
                name: 'home',
                path: '/',
                component: HomeComponent
            },
            {
                name: 'login',
                path: '/user/login',
                component: UserComponent
            },
            {
                name: 'register',
                path: '/user/register',
                component: RegisterComponent
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
            },
            {
                name: 'pageNotFound',
                path: '*',
                component: PageNotFoundComponent
            }
        ];

        return routes;
    }
}

export default new route();