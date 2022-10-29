<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the complain?" @on-ok="deleteStudent"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
       
        <Modal v-model="addModal" title="Add new complain" @on-ok="addStudent" @on-cancel="addModal = false"
            ok-text="Save" draggable sticky loading>
            <div class="col-md-12">
                <div v-if="error != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button @click="error=''" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{ error }}</strong>
                </div>
                <div class="card card-default">
                    <div class="card-body">
                        <div>
                            <div class="form-group row mt-1">
                                <label for="status" class="col-sm-4 col-form-label text-md-right">Complain Type</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.type">
                                        <option value="">Choose...</option>
                                        <option value="Academic">Academic</option>
                                        <option value="Administrative">Administrative</option>
                                        <option value="Transportation">Transportation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Complain</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="form_data.complain" required
                                        autofocus autocomplete="off" placeholder="Enter complain"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>
        <Modal v-model="editModal" title="Answer to the complain" @on-ok="updateStudent" @on-cancel="editModal = false"
            ok-text="Confirm" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Answer</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="edit_data.answer" required
                                        autofocus autocomplete="off" placeholder="Enter answer"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Modal>
        <div class="col-md-6 md-m-5">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Search Complains</label>
                    <div v-if="message_for_search != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button @click="message_for_search = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>

                            <strong>{{ message_for_search }}</strong>
                        </div>
                    <div class="form-group row mt-1">
                        <div class="col-md-8">
                            <select class="form-control" v-model="type">
                                <option value="">Choose...</option>
                                <option value="All">All</option>
                                <option value="Academic">Academic</option>
                                <option value="Administrative">Administrative</option>
                                <option value="Transportation">Transportation</option>
                               
                            </select>
                        </div>
                    </div>

                    <button style="margin-top:10px" class="btn btn-success" @click="searchComplains()">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 md-m-5">
            <h1>Complains</h1>
            <br>
            <span> Total complains: {{ students.length }}</span> 
            <br>
            <div v-if="user.type == 'Student'" >
                <button @click="addModal = true" class="btn btn-sm btn-secondary">Add New Complain</button>
            </div>
        </div>
        

        <div>

        </div>
        <table class="table md-m-5">
            <thead>
                <tr>
                    <th scope="col">Complain</th>
                    <th scope="col">Type</th>
                    <th scope="col">Answer</th>
                    <th v-if="user.type=='Admin'" scope="col">Action</th>
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
                    <td><span>{{ item.complain }}</span> </td>
                    <td><span v-if="item.type" ></span>{{ item.type }}</td>
                    <td><span v-if="item.answer" ></span>{{ item.answer }}</td>
                    <td v-if="user.type=='Admin'">
                        <button style="margin-left:5px" class="btn btn-sm btn-secondary"
                            @click="editStudent(item, index)"> {{item.answer == null ? 'Write' : 'Edit'}} Answer</button>
                        <button style="margin-left:5px" class="btn btn-sm btn-danger"
                            @click="deleteStudentOn(item, index)">Delete</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
import { ref } from 'vue'
export default {
    name: "Complains",
    data() {
        return {
            error: ref(''),
            message_for_search: ref(''),
            students: [],
            loader: true,
            addModal: ref(false),
            deleteModal: ref(false),
            editModal: ref(false),
            editStatusModal: ref(false),
            form_data: {
                complain: '',
                answer: '',
                type: '',
            },
            edit_data: {
                id: 0,
                complain: '',
                answer: '',
                type: '',
            },
            editIndex: -1,
            user: {},
            type: ref('')
        }
    },
    created() {
        this.get_all_teacher()
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
    },

    beforeRouteEnter(to, from, next) {
        if (window.Laravel.user.type == 'Teacher') {
            window.location.href = "/";
        }
        next();
    },
    methods: {
        searchComplains() {
            if(this.type  == ''){
                this.message_for_search = 'Please select a complain type'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/complains/search',{
                    type: this.type
                })
                    .then(response => {
                        if (response.data.data) {
                            this.students = response.data.data
                            this.message_for_search = ""
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
                this.$axios.get('/api/complains/all')
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
            if (this.form_data.type == "") {
                this.error = "complain type is required!"
                return
            }
            else if (this.form_data.complain == "") {
                this.error = "complain is required!"
                return
            }
            
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/complains/create', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.form_data.complain = ''
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
            this.edit_data.complain = item.complain
            this.edit_data.answer = item.answer
            this.edit_data.type = item.type
        },
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },

        updateStudent() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/complains/update', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.edit_data.answer = ''
                            this.edit_data.type = ''
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
        
       
        deleteStudentOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },
        deleteStudent() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/complains/delete', {
                    id: this.edit_data.id
                })
                    .then(response => {
                        if (response.data.data == 1) {
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

<style scoped>
.md-m-5{
        margin-left: 10%;
        margin-right: 10%;
    }
@media (min-width: 320px) and (max-width: 767px) {
    td{
        max-width:150px;
        word-wrap:break-word;
    }
   
    .md-m-5{
        margin: 5%;
    }
    .md-m-l-20{
        margin-left: 20px;
    }
    
}
</style>