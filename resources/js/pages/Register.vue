<template>
    <div class="container" style="margin-top:20px;">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ error }}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header">
                        <h5>Register New User</h5>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus
                                        autocomplete="off" placeholder="Enter your name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" autocomplete="off" class="form-control"
                                        v-model="email" required autofocus placeholder="Enter your email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" autocomplete="off" class="form-control"
                                        v-model="password" required placeholder="Enter your password">
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" autocomplete="off" class="form-control"
                                        v-model="repassword" required placeholder="Enter your password again">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="department">
                                        <option value="">Choose...</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="BBA">BBA</option>
                                        <option value="English">English</option>
                                        <option value="Software Engineering">Software Engineering</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                                <div class="col-md-8">
                                    <input id="student_id" type="text" class="form-control" v-model="student_id"
                                        required autofocus autocomplete="off" placeholder="Enter your student id">
                                </div>
                            </div>


                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        Register
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                        Have an account? Please
                                        <router-link to="/login">login</router-link>
                                    </small>
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
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            repassword: "",
            type: "Student",
            course: "",
            department: "",
            student_id: "",
            error: null,
            notyf: new Notyf()
        }
    },

    methods: {
        ValidateEmail(mail) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
                return true
            }
            return false
        },
        handleSubmit(e) {
            e.preventDefault()
            if (this.name == "") {
                this.error = "Name is required!"
                return
            }
            else if (this.email == "") {
                this.error = "Email is required!"
                return
            }
            else if (this.email.includes("gmailcom")) {
                this.error = "Invalid Email Format!"
                return
            }
            else if (this.ValidateEmail(this.email) == false) {
                this.error = "Invalid Email Format!"
                return
            }
            else if (this.password == "") {
                this.error = "Password is required!"
                return
            }
            else if (this.password.length < 8) {
                this.error = "Password must have 8 characters minimum!"
                return
            }
            else if (this.repassword != this.password) {
                this.error = "Confirm password does not match!"
                return
            }
            else if (this.type == "") {
                this.error = "User type is required!"
                return
            }
            else if (this.department == "") {
                this.error = "Department is required!"
                return
            }
            else if (this.type == "Student" && this.student_id == '') {
                this.error = "Stdent ID is required!"
                return
            }
            else if (this.type == "Teacher" && this.course == '') {
                this.error = "Program is required!"
                return
            }
            console.log("i'm here")
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        type: this.type,
                        course: this.course,
                        department: this.department,
                        student_id: this.student_id,
                    })
                        .then(response => {
                            if (response.data.success) {
                                this.notyf.success({ message: "Your registration has been completed, after giving approval from administration you can access your account. The process will be held within 25-72 hours!", duration: 5000 })
                                setTimeout(() => {
                                    window.location.href = "/login"
                                }, 5000);
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        }
    },


    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
