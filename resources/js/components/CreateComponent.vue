<template>
  <div>
    <h1>Create A Post</h1>
    <form @submit.prevent="addPost">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Post Title:</label>
                    <input type="text" class="form-control" v-model="post.title" minlength = "3" maxlength = "30" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Post Body:</label>
                    <textarea class="form-control" v-model="post.body" rows="5" minlength = "10" maxlength = "50" required></textarea>
                </div>
            </div>
        </div><br />
        <div class="form-group">
            <button class="btn btn-primary">Create</button>
        </div>
    </form>
  </div>
</template>

<script>
    import {PostService} from '../services';
    export default {
        data(){
            return {
                post:{
                    title: '',
                    body: ''
                }
            }
        },
        methods: {
            addPost(){
                // let uri = 'http://127.0.0.1:8000/api/post/create';
                // this.axios.post(uri, post).then((response) => {
                //     this.$router.push({name: 'posts'});
                // });
                PostService.create({
                    title: this.post.title,
                    body: this.post.body,
                }).then(response => {
                    this.$router.push({name: 'posts'});

                    var successStatus = 200;
                    if (response.status == successStatus) {
                        // Notify
                        var notify = $.notify('Create post success!', {
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
        }
    }
</script>
