<template>
    <div>
        <header>
            <div class="container">
                <div class="row">
                    <nav class="navbar sr-navbar navbar-expand-lg col-lg-12 col-md-12 col-sm-12">
                        <div class="sr-logo">
                            <a class="navbar-brand" href="https://smart-ryde.com">
                                <img src="https://smart-ryde.com/themes/smartryde/images/logo.png">
                            </a>
                        </div>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                            <router-link to="/" class="nav-link">Home</router-link>
                            </li>
                            <li class="nav-item">
                            <router-link to="/create" class="nav-link">Create Post</router-link>
                            </li>
                            <li class="nav-item">
                            <router-link to="/posts" class="nav-link">Posts</router-link>
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

    export default{
    }
</script>
