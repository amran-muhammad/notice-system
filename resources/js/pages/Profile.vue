<template>
    <div style="margin-top:20px;">
        <h1 class="md-m-l-10-percent">Profile</h1>
        <div class="d-f">

            <div class="md-m-l-33-percent card" style="width: 11rem;">
                <img v-if="(imageEdit==false && user.image)" class="photo card-img-top" :src="user.image" alt="Card image cap">
                <img v-else-if="imageEdit==false" class="photo card-img-top" src="../../../assets/avatar.png" alt="Card image cap">
                <div v-else>
                    <label class="custom_label">Click to upload a picture
                        <input style="display:none" accept="image/*" type="file" @change="fileUpload" >
                    </label>
                    <img v-if="photo" ondrop="fileUpload" class="photo card-img-top" :src="photo" alt="Card image cap">
                    <img v-else ondrop="fileUpload" class="photo card-img-top" src="../../../assets/avatar.png" alt="Card image cap">
                </div>
                <div class="card-body">
                  <button v-if="imageEdit==true" style="margin-right:10px;margin-left:40px;" class="btn btn-sm btn-danger card-text text-center" @click="imageEdit=false">Cancel</button>
                  <button v-else style="margin-left:10px;" class="btn btn-sm btn-info card-text text-center" @click="imageEdit=true">Change Photo</button>
                </div>
              </div>
    
            <div class="m-l-50 card card-default md-m-t-20">
                <div  v-if="success_message != ''"
                    class="alert alert-success alert-dismissible fade show" role="alert">
                    <button @click="success_message = ''" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
                    <strong>{{ success_message }}</strong>
                </div>
                <div class="card-header">
                    <h5>{{ user.name }}</h5>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" v-model="user.name" required autofocus
                                    autocomplete="off" placeholder="Enter your name">
                            </div>
                        </div>
    
                        <div class="form-group row mt-1">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail</label>
                            <div class="col-md-8">
                                <input id="email" type="email" autocomplete="off"  class="form-control" v-model="user.email" required autofocus
                                 placeholder="Enter your email">
                            </div>
                        </div>
    
                        <div class="form-group row mt-1">
                            <label for="type" class="col-sm-4 col-form-label text-md-right">User Type</label>
                            <div class="col-md-8">
                                <span class="form-control">
                                    {{ user.type }}
                                </span>
                            </div>
                        </div>
    
    
    
                        <div v-if="user.department" class="form-group row mt-1">
                            <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                            <div class="col-md-8">
                                <span class="form-control">
                                    {{ user.department }}
                                </span>
                            </div>
                        </div>
    
                        <div v-if="user.type == 'Teacher'" class="form-group row mt-1">
                            <label for="course" class="col-sm-4 col-form-label text-md-right"> Course Name</label>
                            <div class="col-md-8">
                                <span class="form-control">
                                    {{ user.course }}
                                </span>
                            </div>
                        </div>
    
                        <div v-if="user.type == 'Student'" class="form-group row mt-1">
                            <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                            <div class="col-md-8">
                                <span class="form-control">
                                    {{ user.student_id }}
                                </span>
                            </div>
                        </div>
    
    
                        <div class="form-group row mt-1 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button style="margin-top:10px;" type="submit" class="btn btn-success" @click="updateUser()">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-l-50 card card-default md-m-t-20">
                
                <div class="card-header">
                    <h5>Change Your Pasword</h5>
                </div>
                <div  v-if="success_message_password != ''"
                    class="alert alert-success alert-dismissible fade show" role="alert">
                    <button @click="success_message_password = ''" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
                    <strong>{{ success_message_password }}</strong>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label text-md-right">Old Password</label>
                            <div class="col-md-8">
                                <input id="password1" type="password" autocomplete="off"  class="form-control" v-model="password_data.old_password" required autofocus
                                    >
                            </div>
                        </div>
    
                        <div class="form-group row mt-1">
                            <label for="password" class="col-sm-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-8">
                                <input id="password2" type="password" autocomplete="off"  class="form-control" v-model="password_data.new_password" required autofocus
                                    >
                            </div>
                        </div>
    
                        <div class="form-group row mt-1 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button style="margin-top:10px;" type="submit" class="btn btn-success" @click="updatePassword()">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Profile",
    data() {
        return {
            user: {
                id: '',
                name: "",
                email: "",
                password: "",
                type: "",
                course: "",
                department: "",
                student_id: "",
                image: "",
            },
            password_data:{
                email: '',
                old_password: '',
                new_password:''
            },
            success_message: ref(''),
            success_message_password: ref(''),
            photo: ref(''),
            imageEdit: ref(false),
        }
    },
    created() {
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.user) {
            window.location.href = "/login";
        }
        next();
    },
    methods: {
        fileUpload($e){
            let form_image = new FormData()
            form_image.append('old_file', $e.target.files[0])
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/teachers/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
                    .then(response => {
                        if (response.data.data) {
                            this.photo = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })

        },
        updatePassword() {
            if(this.password_data.new_password.length<8){
                this.success_message_password = "New password must have 8 characters minimum!"
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.password_data.email = this.user.email;
                
                this.$axios.post('/api/user/update/password', this.password_data)
                    .then(response => {
                        if (response.data.data) {
                            this.success_message_password = "Your password is changed successfully!"
                            this.password_data.new_password = ''
                            this.password_data.old_password = ''
                        } else {
                            this.success_message_password = "Your old password is incorrect!"
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        updateUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let obj = {
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                }
                if(this.photo != ''){
                    obj.image = this.photo
                }
                this.$axios.post('/api/user/update/data', obj)
                    .then(response => {
                        if (response.data.data) {
                            this.success_message = "Your profile has been updated successfully!"
                            this.user = response.data.data
                            this.imageEdit=false
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>
.custom_label{
    padding-left: 20px;
    padding-top: 100px;
    z-index: 111;
    position: absolute;
    color: #040404;
    font-size: 12px;
}
.m-l-50{
    margin-left: 50px;
}
.m-t{
    margin-top: 20px;
}
.photo{
    border-radius: 50%;
    max-width: 150px;
    max-height: 150px;
    margin:10px;
}
.text-center{
    text-align: center;
}
.d-f{
    display:flex;
    margin-left: 20%;
}
.md-m-l-10-percent{
        margin-left:10%;
    }
/* Mobile to Tablet  */
@media (min-width: 320px) and (max-width: 767px) {
    .d-f{
        display:block;
    }
    .md-m-t-20{
        margin-top: 20px;
    }
    .md-m-l-33-percent{
        margin-left:33%;
    }
    
}
</style>