// IndexComponent.vue

<template>
<div>
    <h1>Posts</h1>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
        <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Post</router-link>
        </div>
    </div><br />

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th v-show="isLogin">Actions</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td>{{ post.body }}</td>
                <td v-show="isLogin"><router-link :to="{name: 'edit', params: { slug: post.slug }}" class="btn btn-primary">Edit</router-link></td>
                <td v-show="isLogin">
                    <button class="btn btn-danger" @click.prevent="deletePost(post.slug)">Delete</button>

                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
    import {PostService} from '../services';

    export default {
        data() {
            return {
                posts: [],
                isLogin: false
            }
        },

        created() {
            PostService.index().then(response => {
                this.posts = response.data;
            });

            // Check login
            if (sessionStorage.getItem('access_token')) {
                this.isLogin = true;
            }
        },

        methods: {
            deletePost(slug) {
                var result = confirm("Want to delete?");
                if (result) {
                    PostService.destroy(slug).then(response => {
                        // Find index
                        var index = this.findWithAttr(this.posts, 'slug', slug)

                        this.posts.splice(index, 1);

                        var successStatus = 200;
                        if (response.status == successStatus) {
                            // Notify
                            var notify = $.notify('Delete post success!', {
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

            findWithAttr(array, attr, value) {
                for(var i = 0; i < array.length; i++) {
                    if(array[i][attr] === value) {
                        return i;
                    }
                }
                return -1;
            }
        }
    }
</script>
