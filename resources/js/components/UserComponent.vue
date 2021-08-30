<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="loginHandle">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>User:</label>
                        <input type="text" name='name' class="form-control" v-model="user.name" v-validate="'required|max:10|min:3'">
                        <span class="text-danger">{{ errors.first('name') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" v-model="user.password" v-validate="'required|max:10|min:6'">
                    <span class="text-danger">{{ errors.first('password') }}</span>
                    </div>
                </div>
            </div><br />
            <div class="form-group">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</template>
<script>
    import {UserService} from '../services';


    export default {
        data() {
            return {
                user: {
                    name: '',
                    password: ''
                }
            }
        },

        methods: {
            loginHandle() {
                // Validate
                this.$validator.validateAll()
                .then((result) => {
                    if (result) {
                        UserService.login({
                            name: this.user.name,
                            password: this.user.password,
                        }).then(response => {
                            var successStatus = 200;
                            if (response.status == successStatus) {
                                // Add token key
                                sessionStorage.setItem('access_token', response.access_token);

                                // Change route
                                this.$router.push({name: 'posts'});
                                this.$router.go()
                                // Notify
                                var notify = $.notify('Login success!', {
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
                })
            }
        }
    }
</script>