<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the student?" @on-ok="deleteStudent"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="editStatusModal" title="Are you sure update the status?" @on-ok="updateStudentStatus"
            @on-cancel="editStatusModal = false" ok-text="Confirm" draggable sticky loading>
        </Modal>
        <Modal v-model="addModal" title="Add new student" @on-ok="addStudent" @on-cancel="addModal = false"
            ok-text="Save" draggable sticky loading>
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
                                    <input id="email" type="email" autocomplete="off"  class="form-control" v-model="form_data.email"
                                        required autofocus placeholder="Enter email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" autocomplete="off"  class="form-control"
                                        v-model="form_data.password" required
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
                                <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.status">
                                        <option value="">Choose...</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                                <div class="col-md-8">
                                    <input id="student_id" type="text" class="form-control"
                                        v-model="form_data.student_id" required autofocus autocomplete="off"
                                        placeholder="Enter student id">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>
        <Modal v-model="editModal" title="Edit a student" @on-ok="updateStudent" @on-cancel="editModal = false"
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
                                    <input id="email" type="email" autocomplete="off"  class="form-control" v-model="edit_data.email"
                                        required autofocus placeholder="Enter email">
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
                                <label for="student_id" class="col-sm-4 col-form-label text-md-right">Student ID</label>
                                <div class="col-md-8">
                                    <input id="student_id" type="text" class="form-control"
                                        v-model="edit_data.student_id" required autofocus autocomplete="off"
                                        placeholder="Enter student id">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>

        <div class="col-md-6 md-m-l-10-percent">
            <h1>Students</h1>
            <br>
            Total students: {{ students.length }}
            <br>
            <div>
                <button @click="addModal = true" class="btn btn-sm btn-secondary">Add New Student</button>
            </div>
        </div>
        <div class="col-md-6 md-m-l-10-percent">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Find A Student</label>
                    <input id="search" type="text" class="form-control" v-model="search" autofocus autocomplete="off"
                        placeholder="Enter Student ID/Email/Name">

                    <button style="margin-top:10px" class="btn btn-success" @click="searchUser()">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div>

        </div>
        <table style="max-width:max-content" class="table computer_student_table">
            <thead>
                <tr>
                    <th scope="col">Student Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Department</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="loader">
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

            </tbody>
            <tbody v-else>
                <tr v-for="(item, index) in students" :key="index">
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.student_id }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.status }}</td>
                    <td>
                        <button v-if="item.status == 'Pending'" class="btn btn-sm btn-success"
                            @click="editStatusModalOn(item, index)"><i class="fa fa-check"></i></button>
                        <button v-else class="btn btn-sm btn-info"
                            @click="editStatusModalOn(item, index)">x</button>
                        <!-- <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="editStudent(item, index)">Edit</button> -->
                        <button style="margin-left:5px" class="btn btn-sm btn-danger"
                            @click="deleteStudentOn(item, index)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
        <table style="max-width:max-content" class="table mobile_student_table">
            <tbody v-if="loader">
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

            </tbody>
            <tbody v-else v-for="(item, index) in students" :key="index">
                <tr>
                    <td>Student Name</td>
                    <td>{{ item.name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ item.email }}</td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>{{ item.student_id }}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{ item.department }}</td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>{{ item.status }}</td>
                </tr>

                <tr>
                    <td>Action</td>
                    <td>
                        <button v-if="item.status == 'Pending'" class="btn btn-sm btn-success"
                            @click="editStatusModalOn(item, index)"><i class="fa fa-check"></i></button>
                        <button v-else class="btn btn-sm btn-info"
                            @click="editStatusModalOn(item, index)">x</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="editStudent(item, index)"><i class="fa fa-edit"></i></button>
                        <button style="margin-left:5px" class="btn btn-sm btn-danger"
                            @click="deleteStudentOn(item, index)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue'
export default {
    name: "Students",
    data() {
        return {
            error: ref(''),
            students: [],
            loader: true,
            addModal: ref(false),
            deleteModal: ref(false),
            editModal: ref(false),
            editStatusModal: ref(false),
            form_data: {
                name: '',
                email: '',
                password: '',
                department: '',
                course: '',
                status: '',
                type: 'Student'
            },
            edit_data: {
                id: 0,
                name: '',
                email: '',
                password: '',
                department: '',
                course: '',
                status: '',
                type: 'Student'
            },
            editIndex: -1,
            search: ''
        }
    },
    created() {
        this.get_all_teacher()
    },

    beforeRouteEnter(to, from, next) {
        if (window.Laravel.user.type != 'Admin') {
            window.location.href = "/";
        }
        next();
    },
    methods: {
        get_all_teacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/students/all')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.students = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addStudent() {
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

            else if (this.form_data.password.length < 8) {
                this.error = "Password must have 8 characters minimum!"
                return
            }
            
            else if (this.form_data.department == "") {
                this.error = "Department is required!"
                return
            }
            
            else if (this.form_data.student_id == '') {
                this.error = "Student ID is required!"
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/create/new/student', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.students.unshift(response.data.data)
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editStudent(item, index) {
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.name = item.name
            this.edit_data.department = item.department
            this.edit_data.student_id = item.student_id
            this.edit_data.email = item.email
        },
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.status = item.status == 'Pending' ? 'Approved' : 'Pending'
        },

        updateStudent() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.students[this.editIndex] = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        updateStudentStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/update/data', { id: this.edit_data.id, status: this.edit_data.status })
                    .then(response => {
                        if (response.data.data) {
                            this.editStatusModal = false
                            this.students[this.editIndex].id = response.data.data.id
                            this.students[this.editIndex].status = response.data.data.status
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        searchUser() {
            this.loader = true
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/user/search' + '?search=' + search.value + '&type=Student')
                    .then(response => {
                        if (response.data.data) {
                            this.loader = false
                            this.students = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        deleteStudentOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },
        deleteStudent() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/user/delete', {
                    id: this.edit_data.id
                })
                    .then(response => {
                        if (response.data.data) {
                            this.deleteModal = false
                            this.students.splice(this.editIndex, 1)
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
.md-m-l-10-percent{
            margin-left:10%;
        }
.mobile_student_table{
    display: none;
}
.computer_student_table{
    display: block;
    margin-left: 10%;
}
@media (min-width: 320px) and (max-width: 767px) {
    .mobile_student_table{
        display: block;
        margin-left: 2%;
    }
    .computer_student_table{
        display: none;
    }
}
</style>