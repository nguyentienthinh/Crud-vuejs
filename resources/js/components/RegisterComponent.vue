<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="registerHandle">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>User:</label>
                        <input type="text" name='name' class="form-control" v-model="user.name" v-validate="'required|max:10|min:3'">
                        <span class="text-danger">{{ errors.first('name') }}</span>
                        <span class="text-danger">{{errorValidate.name}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name='email' class="form-control" v-model="user.email" v-validate="'required|email|max:50|min:10'">
                        <span class="text-danger">{{ errors.first('email') }}</span>
                        <span class="text-danger">{{errorValidate.email}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" v-model="user.password" v-validate="'required|max:10|min:6'" placeholder="Password">
                    <span class="text-danger">{{ errors.first('password') }}</span>
                    <span class="text-danger">{{errorValidate.password}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="form-control" v-model="user.confirmPassword" v-validate="'required|confirmed:password|max:10|min:6'" placeholder="Password, Again">
                    <span class="text-danger">{{ errors.first('password_confirmation') }}</span>
                    <span class="text-danger">{{errorValidate.password_confirmation}}</span>
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
                    email: '',
                    password: '',
                    confirmPassword: ''
                },
                errorValidate: {
                    name: '',
                    email: '',
                    password: '',
                    confirmPassword: ''
                }
            }
        },

        methods: {
            registerHandle() {
                // Validate
                this.$validator.validateAll()
                .then((result) => {
                    if (result) {
                        UserService.register({
                            name: this.user.name,
                            email: this.user.email,
                            password: this.user.password,
                            confirmPassword: this.user.confirmPassword
                        }).then(response => {
                            var successStatus = 200;
                            if (response.status == successStatus) {
                                // Change route
                                this.$router.push({name: 'login'});
                                // Notify
                                var notify = $.notify('Register account success!', {
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

                            var errorValidateStatus = 400;
                            if (response.status == errorValidateStatus) {
                                this.errorValidate = response.data;
                            }
                        })
                    }
                })
            }
        }
    }
</script>