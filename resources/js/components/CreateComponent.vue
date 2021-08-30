<template>
  <div>
    <h1>Create A Post</h1>
    <form @submit.prevent="addPost">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Post Title:</label>
                    <input type="text" name='postTitle' class="form-control" v-model="post.title" v-validate="'required|max:30|min:3'">
                    <span class="text-danger">{{ errors.first('postTitle') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Post Body:</label>
                    <textarea name="postBody" class="form-control" v-model="post.body" rows="5" v-validate="'required|max:50|min:10'"></textarea>
                    <span class="text-danger">{{ errors.first('postBody') }}</span>
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
                // Validate
                this.$validator.validateAll()
                .then((result) => {
                    if (result) {
                        // Handle create
                        PostService.create({
                            title: this.post.title,
                            body: this.post.body,
                        }).then(response => {
                            var successStatus = 200;
                            if (response.status == successStatus) {
                                // Change route
                                this.$router.push({name: 'posts'});
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
                });
            }
        }
    }
</script>
