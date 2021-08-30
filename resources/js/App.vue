<template>
    <div>
        <header>
            <div class="container">
                <div class="row">
                    <nav class="navbar sr-navbar navbar-expand-lg col-lg-12 col-md-12 col-sm-12">
                        <div class="sr-logo">
                            <a class="navbar-brand" href="/">
                                <img src="https://smart-ryde.com/themes/smartryde/images/logo.png">
                            </a>
                        </div>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link to="/" class="nav-link">Home</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/posts/create" class="nav-link" v-show="isLogin">Create Post</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/posts" class="nav-link">Posts</router-link>
                            </li>

                            <li class="nav-item dropdown" id="userAccess" v-show="!isLogin">
                                <router-link to="" class="dropdown-toggle nav-link" data-toggle="dropdown">Login/Register</router-link>
                                <div class="dropdown-menu">
                                    <router-link to="/user/login" class="nav-link dropdown-item">Login</router-link>
                                    <router-link to="/user/register" class="nav-link dropdown-item">Register</router-link>
                                </div>
                            </li>

                            <li class="nav-item dropdown" id="userInfo" v-show="isLogin">
                                <router-link to="" class="dropdown-toggle nav-link" data-toggle="dropdown">{{user}}</router-link>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Info</a>
                                    <a class="dropdown-item" href="" @click.prevent="logout()">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
            <div class="container">
                <transition name="bounce">
                    <router-view></router-view>
                </transition>
            </div>
    </div>
</template>

<style>
    .bounce-enter-active {
        animation: bounce-in .5s;
    }
    .bounce-leave-active {
        animation: bounce-in .5s reverse;
    }
    @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }
</style>

<script>
    import {UserService} from './services';

    export default{
        data() {
            return {
                user: '',
                isLogin: false
            }
        },

        created() {
            UserService.getUser().then(response => {
                if (response) {
                    var successStatus = 200;
                    if (response.status == successStatus) {
                        this.user = response.user;

                        // Show User info and hide user access menu
                        this.isLogin = true;
                    }
                }
            })
        },

        methods: {
            logout() {
                UserService.logout(
                    {
                        token : sessionStorage.getItem('access_token')
                    }
                ).then(response => {
                    var successStatus = 200;
                    if (response.status == successStatus) {
                        // Change route
                        let homeRoute = 'home';
                        if (this.$router.currentRoute.name != homeRoute) {
                            this.$router.push({name: homeRoute});
                            this.$router.go()
                        }

                        // Remove token
                        sessionStorage.removeItem('access_token');

                        // Notify
                        var notify = $.notify('Logout success!', {
                            type: 'success',
                            allow_dismiss: true,
                        });
                    } else {
                        // Notify
                        var notify = $.notify(response.message, {
                            type: 'danger',
                            allow_dismiss: true,
                        });
                    }
                })
            }
        },
    }
</script>
