<template>
    <div class="container" style="margin-top:20px;">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button @click="error = null" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ error }}</strong>
                </div>
                <div v-if="success !== null" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button @click="success = null" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ success }}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header">
                        <h5>Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <form v-if="step==1">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" autocomplete="off"  class="form-control" v-model="email" required
                                        autofocus placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="sendCodeToEmail">
                                        Send Verification Code
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form v-else-if="step==2">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Enter Verification Code</label>
                                <div class="col-md-8">
                                    <input id="email" type="text" autocomplete="off"  class="form-control" v-model="code" required
                                        autofocus>
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="checkCode">
                                        Verify Code
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form v-else-if="step==3">
                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" autocomplete="off"  class="form-control" v-model="password"
                                        required placeholder="Enter new password">
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Enter Password Again</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" autocomplete="off"  class="form-control" v-model="repassword"
                                        required placeholder="Enter password again">
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="setNewPassword">
                                        Save Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { Notyf } from 'notyf';
import { ref } from 'vue';
export default {
    data() {
        return {
            email: "",
            code: "",
            password: "",
            repassword: "",
            error: null,
            success:null,
            notyf: new Notyf(),
            step: ref(1)
        }
    },

    methods: {
        sendCodeToEmail(e) {
            this.step = 2
            e.preventDefault()
                    this.$axios.post('api/send-verification-code', {
                        email: this.email,
                    })
                        .then(response => {
                            if (response.data.success==true) {
                                this.error = null
                                this.success = "Verification code sent to your email,please check!"
                            } else {
                                this.step = 1
                                this.error = response.data.message
                                this.success = null
                            }
                        })
                        .catch(function (error) {
                            this.step = 1
                            this.success = null
                            this.error = "Try Again!"
                            console.error(error);
                        });
        },
        checkCode(e) {
            e.preventDefault()
                    this.$axios.post('api/check-verification-code', {
                        email: this.email,
                        code: this.code
                    })
                        .then(response => {
                            if (response.data.success==true) {
                                this.success = "Set a new password now!"
                                this.error = null
                                this.step = 3
                            } else {
                                this.error = response.data.message
                                this.success = null
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                            this.success = null
                            this.error = "Try Again!"
                        });
        },
        setNewPassword(e) {
            e.preventDefault()
            if(this.password !=this.repassword){
                this.error = "Password does not match!"
                return
            }
            if(this.password.length < 8 || this.repassword.length < 8){
                this.error = "Password must have 8 characters minimum!"
                return
            }
                    this.$axios.post('api/set-new-password', {
                        email: this.email,
                        password :this.password
                    })
                        .then(response => {
                            if (response.data.success==true) {
                                this.success = "Password changed!"
                                this.error = null
                                window.location.href='login'
                            } else {
                                this.error = response.data.message
                                this.success = null
                            }
                        })
                        .catch(function (error) {
                            this.success = null
                            this.error = "Try Again!"
                            console.error(error);
                        });
        }
    },

    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('');
        }
        next();
    }
}
</script>