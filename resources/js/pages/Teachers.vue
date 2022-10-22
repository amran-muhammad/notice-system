<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the teacher?" @on-ok="deleteTeacher"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="editStatusModal" title="Are you sure update the status?" @on-ok="updateTeacherStatus"
            @on-cancel="editStatusModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="addModal" title="Add New Teacher" @on-ok="addTeacher" @on-cancel="addModal = false"
            ok-text="Confirm" draggable sticky loading>
            <div class="col-md-12">
                <div v-if="error != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button @click="error=''" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ error }}</strong>
                </div>
                <div class="card card-default">

                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="form_data.name" required
                                        autofocus autocomplete="off" placeholder="Enter name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="form_data.email"
                                        required autofocus autocomplete="off" placeholder="Enter email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control"
                                        v-model="form_data.password" required autocomplete="off"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.department">
                                        <option value="">Choose...</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="BBA">BBA</option>
                                        <option value="English">English</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="course" class="col-sm-4 col-form-label text-md-right"> Program Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.course">
                                        <option value="">Choose...</option>
                                        <option value="Honors & Masters">Honors & Masters</option>
                                        <option value="Honors">Honors</option>
                                        <option value="Masters">Masters</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Image Link</label>
                                <div class="col-md-8">
                                    <input id="name" type="file" accept="image/*" class="form-control"  @change="fileUpload" required
                                        autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.status">
                                        <option value="">Choose...</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>

        <Modal v-model="editModal" title="Edit New Teacher" @on-ok="updateTeacher" @on-cancel="editModal = false"
            ok-text="Confirm" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">

                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="edit_data.name" required
                                        autofocus autocomplete="off" placeholder="Enter name">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="edit_data.email"
                                        required autofocus autocomplete="off" placeholder="Enter email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.department">
                                        <option value="">Choose...</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="BBA">BBA</option>
                                        <option value="English">English</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="course" class="col-sm-4 col-form-label text-md-right"> Program Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.course">
                                        <option value="">Choose...</option>
                                        <option value="Honors & Masters">Honors & Masters</option>
                                        <option value="Honors">Honors</option>
                                        <option value="Masters">Masters</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Image Link</label>
                                <div class="col-md-8">
                                    <input id="name" type="file" accept="image/*" class="form-control"  @change="editFileUpload" required
                                        autofocus autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>

        <div class="col-md-6 mobile-card">
            <h1>Teachers</h1>
            <br>
            Total teachers: {{ teachers.length }}
            <br>
            <div v-if="user.type=='Admin'">
                <button @click="addModal = true" class="btn btn-sm btn-secondary">Add New Teacher</button>
            </div>
        </div>
       
        <br>
        <div class="row mobile-table" style="max-width: 1720px;">
            
            <div class="col-md-12" v-if="loader">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>

            </div>
            <div style="margin-top:10px;" v-else>
                <div class="row">
                    <div class="col-md-4 card mobile-card-margin" style="width: 18rem;" v-for="(item, index) in teachers" :key="index">
                        <img class="card-img-top" :src="item.image" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ item.name }}</h5>
                            <h5 class="card-title">Email: {{ item.email }}</h5>
                            <p class="card-text">Program: {{ item.course }} , {{ item.department }}</p>
                            <p v-if="user.type=='Admin'">{{ item.status }}</p>
                            <div v-if="user.type=='Admin'">
                                <button v-if="item.status == 'Pending'" class="btn btn-sm btn-success"
                                    @click="editStatusModalOn(item, index)">Activate</button>
                                <button v-else class="btn btn-sm btn-info"
                                    @click="editStatusModalOn(item, index)">Deactivate</button>
                                <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                                    @click="editTeacher(item, index)">Edit</button>
                                <button style="margin-left:5px" class="btn btn-sm btn-danger"
                                    @click="deleteTeacherOn(item, index)">Delete</button>
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
    name: "Teachers",
    data() {
        return {
            error: ref(''),
            deleteModal: ref(false),
            addModal: ref(false),
            editModal: ref(false),
            search: ref(''),
            teachers: [],
            editIndex: -1,
            loader: true,
            form_data: {
                name: '',
                email: '',
                password: '',
                image: '',
                department: '',
                course: '',
                status: '',
                type: 'Teacher'
            },
            edit_data: {
                id: '',
                name: '',
                email: '',
                image: '',
                password: '',
                department: '',
                course: '',
                status: '',
                type: 'Teacher'
            },
            editStatusModal: ref(false),
            user: {},
        }
    },
    created() {
        this.get_all_teacher()
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
                            this.form_data.image = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })

        },
        editFileUpload($e){
            let form_image = new FormData()
            form_image.append('old_file', $e.target.files[0])
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/teachers/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
                    .then(response => {
                        if (response.data.data) {
                            this.edit_data.image = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })

        },
        get_all_teacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/teachers/all?department='+this.$route.query.department)
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.teachers = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addTeacher() {
           if (this.form_data.name == "") {
                this.error = "Name is required!"
                return
            }
            else if (this.form_data.email == "") {
                this.error = "Email is required!"
                return
            }
            else if (this.form_data.password == "") {
                this.error = "Password is required!"
                return
            }
            
            else if (this.form_data.department == "") {
                this.error = "Department is required!"
                return
            }
            
            else if (this.form_data.course == '') {
                this.error = "Course is required!"
                return
            }
            else if (this.form_data.image == '') {
                this.error = 'Please provide a event image link'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/create/new/teacher', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.teachers.unshift(response.data.data)
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editTeacher(item, index) {
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.name = item.name
            this.edit_data.department = item.department
            this.edit_data.course = item.course
            this.edit_data.email = item.email
            this.edit_data.image = item.image ? item.image : null
        },
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.status = item.status == 'Pending' ? 'Approved' : 'Pending'
        },

        updateTeacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.teachers[this.editIndex] = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        updateTeacherStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', { id: this.edit_data.id, status: this.edit_data.status })
                    .then(response => {
                        if (response.data.data) {
                            this.editStatusModal = false
                            this.teachers[this.editIndex].id = response.data.data.id
                            this.teachers[this.editIndex].status = response.data.data.status
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
      
        deleteTeacherOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },
        deleteTeacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/delete', {
                    id: this.edit_data.id
                })
                    .then(response => {
                        if (response.data.data) {
                            this.deleteModal = false
                            this.teachers.splice(this.editIndex, 1)
                            this.editIndex = -1
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
}
</script>

<style>
.mobile-card-margin{
        margin:10px;
    }
    .mobile-card{
        margin-left:10%;
    }
    .mobile-table{
        margin-left:10%;
    }
    @media (min-width: 320px) and (max-width: 767px) {
        .mobile-table{
            margin-right: 20%;
        }
    }
</style>