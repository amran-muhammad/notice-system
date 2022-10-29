<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the notice?" @on-ok="deleteNotice"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="addModal" title="Add New Notice" @on-ok="addNotice" @on-cancel="addModal = false"
            ok-text="Save" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div v-if="message != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button @click="message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <strong>{{ message }}</strong>
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Title</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="form_data.title" required autofocus
                                        autocomplete="off" placeholder="Enter title"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Department Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.department_name">
                                        <option value="">Choose...</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="BBA">BBA</option>
                                        <option value="English">English</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Semester Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.class_name">
                                        <option value="">Choose...</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="3rd Semester">3rd Semester</option>
                                        <option value="4th Semester">4th Semester</option>
                                        <option value="5th Semester">5th Semester</option>
                                        <option value="6th Semester">6th Semester</option>
                                        <option value="7th Semester">7th Semester</option>
                                        <option value="8th Semester">8th Semester</option>
                                        <option value="9th Semester">9th Semester</option>
                                        <option value="10th Semester">10th Semester</option>
                                        <option value="11th Semester">11th Semester</option>
                                        <option value="12th Semester">12th Semester</option>
                                        <option value="Masters 1st Semester">Masters 1st Semester</option>
                                        <option value="Masters 2nd Semester">Masters 2nd Semester</option>
                                        <option value="Masters 3rd Semester">Masters 3rd Semester</option>
                                    </select>
                                    </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Section</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="form_data.section">
                                        <option value="">Choose...</option>
                                        <option value="All">All</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Image Link</label>
                                <div class="col-md-8">
                                    <input id="name" type="file" accept="image/*" class="form-control"  @change="fileUpload" required
                                        autofocus autocomplete="off">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </Modal>
        <Modal v-model="editModal" title="Edit Notice" @on-ok="updateNotice" @on-cancel="editModal = false"
            ok-text="Update" draggable sticky loading>
            <div class="col-md-12">
                <div class="card card-default">
                    <div v-if="message != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button @click="message = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <strong>{{ message }}</strong>
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Title</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="edit_data.title" required autofocus
                                        autocomplete="off" placeholder="Enter title"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Department Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.department_name">
                                        <option value="">Choose...</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="BBA">BBA</option>
                                        <option value="English">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Semester Name</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.class_name">
                                        <option value="">Choose...</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="3rd Semester">3rd Semester</option>
                                        <option value="4th Semester">4th Semester</option>
                                        <option value="5th Semester">5th Semester</option>
                                        <option value="6th Semester">6th Semester</option>
                                        <option value="7th Semester">7th Semester</option>
                                        <option value="8th Semester">8th Semester</option>
                                        <option value="9th Semester">9th Semester</option>
                                        <option value="10th Semester">10th Semester</option>
                                        <option value="11th Semester">11th Semester</option>
                                        <option value="12th Semester">12th Semester</option>
                                        <option value="Masters 1st Semester">Masters 1st Semester</option>
                                        <option value="Masters 2nd Semester">Masters 2nd Semester</option>
                                        <option value="Masters 3rd Semester">Masters 3rd Semester</option>
                                    </select>
                                    </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Section</label>
                                <div class="col-md-8">
                                    <select class="form-control" v-model="edit_data.section">
                                        <option value="">Choose...</option>
                                        <option value="">All</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
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

        <h1 class="md-m-l-10-percent">Notices</h1>

        <div v-if="user.type=='Teacher' || user.type=='Admin'" class="col-md-6 md-m-l-10-percent">
            <div>
                <button @click="addModalOn()" class="btn btn-sm btn-secondary">Add New Notice</button>
            </div>
        </div>
        <div class="col-md-6 md-m-5">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="search" class="col-sm-4 col-form-label text-md-right">Search Notice</label>
                        <div v-if="message_for_search != ''" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button @click="message_for_search = ''" type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>

                            <strong>{{ message_for_search }}</strong>
                        </div>
                        <div class="form-group row mt-1">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Department Name</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="search_data.department_name">
                                    <option value="">Choose...</option>
                                    <option value="CSE">CSE</option>
                                    <option value="EEE">EEE</option>
                                    <option value="BBA">BBA</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                        </div>
                           
                        <div class="form-group row mt-1">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Semester Name</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="search_data.class_name">
                                    <option value="">Choose...</option>
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                    <option value="3rd Semester">3rd Semester</option>
                                    <option value="4th Semester">4th Semester</option>
                                    <option value="5th Semester">5th Semester</option>
                                    <option value="6th Semester">6th Semester</option>
                                    <option value="7th Semester">7th Semester</option>
                                    <option value="8th Semester">8th Semester</option>
                                    <option value="9th Semester">9th Semester</option>
                                    <option value="10th Semester">10th Semester</option>
                                    <option value="11th Semester">11th Semester</option>
                                    <option value="12th Semester">12th Semester</option>
                                    <option value="Masters 1st Semester">Masters 1st Semester</option>
                                    <option value="Masters 2nd Semester">Masters 2nd Semester</option>
                                    <option value="Masters 3rd Semester">Masters 3rd Semester</option>
                                </select>
                                </div>
                        </div>
                        <div class="form-group row mt-1">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Section</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="search_data.section">
                                    <option value="">Choose...</option>
                                    <option value="">All</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                </select>
                            </div>
                        </div>

                    <button style="margin-top:10px" class="btn btn-success" @click="searchNotice()">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <br>
        <div class="notice" v-for="(item, index) in notices" :key="index">
            <img class="main_image_notice" :src="item.image" alt="no photo">
            <div class="action-button">
                <h5>{{item.title}}</h5>
            </div>
            <div class="details">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Department</th>
                            <th scope="col">Semester Name</th>
                            <th scope="col">Section</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row"> <span v-if="item.department_name" >{{item.department_name}}</span>  </th>
                        <td> <span  v-if="item.class_name" >{{item.class_name}}</span></td>
                        <td><span v-if="item.section">{{item.section}}</span> </td>
                        <td>
                                <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-secondary"
                                        @click="editNotice(item, index)">Edit</button>
                                <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-danger"
                                        @click="deleteNoticeOn(item, index)">Delete</button>
                                <a :href="item.image" download style="margin-left:5px;"  class="btn btn-sm btn-primary">Download</a>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Notices",
    data() {
        return {
            deleteModal: ref(false),
            addModal: ref(false),
            editModal: ref(false),
            notices: [],
            notice_type: "",
            form_data: {
                class_name: '',
                department_name: '',
                section: '',
                title: '',
                image: '',
            },
            edit_data: {
                class_name: '',
                department_name: '',
                section: '',
                title: '',
                image: '',
                id: '',
            },
            search_data: {
                class_name: '',
                department_name: '',
                section: '',
            },
            limit: ref(0),
            user: {},
            message: ref(''),
            message_for_search: ref(''),
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
                this.$axios.post('/api/notices/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
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
                this.$axios.post('/api/notices/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
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
      
        searchNotice() {
            if(this.search_data.department_name  == '' && this.search_data.class_name  == '' && this.search_data.section  == ''){
                this.message_for_search = 'Please select a Department/Semseter/Section name'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/notices/search',this.search_data)
                    .then(response => {
                        if (response.data.data) {
                            this.notices = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addNotice() {
            if (this.form_data.title == '') {
                this.message = 'Please write a title'
                return
            }
           
            else if (this.form_data.department_name == '') {
                this.message = 'Select a department name'
                return
            }
           
            else if (this.form_data.image == '') {
                this.message = 'Please provide a notice image link'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/notices/create', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.notices.unshift(response.data.data)
                            this.form_data.class_name = ''
                            this.form_data.department_name = ''
                            this.form_data.section = ''
                            this.form_data.title = ''
                            this.form_data.image = ''
                        } else {
                            if (response.data.msg) {
                                this.message = response.data.msg
                                return
                            } else {
                                console.log(response);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editNotice(item, index) {
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.department_name = item.department_name
            this.edit_data.class_name = item.class_name
            this.edit_data.section = item.section
            this.edit_data.title = item.title
            this.edit_data.image = item.image
        },
        deleteNoticeOn(item, index) {
            this.deleteModal = true
            this.editIndex = index
            this.edit_data.id = item.id
        },
        deleteNotice() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/notices/delete', {
                    id: this.edit_data.id
                })
                    .then(response => {
                        if (response.data.data) {
                            this.deleteModal = false
                            this.notices.splice(this.editIndex, 1)
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

        updateNotice() {
            if (this.edit_data.title == '') {
                this.message = 'Please write a title'
                return
            }
            else if (this.edit_data.class_name == '') {
                this.message = 'Select a semester name'
                return
            }
            else if (this.edit_data.department_name == '') {
                this.message = 'Select a department name'
                return
            }
            else if (this.edit_data.section == '') {
                this.message = 'Select a section name'
                return
            }
            else if (this.edit_data.image == '') {
                this.message = 'Please provide a notice image link'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/notices/update', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.notices[this.editIndex] = response.data.data
                            this.edit_data.title = ''
                            this.edit_data.department_name = ''
                            this.edit_data.section = ''
                            this.edit_data.class_name = ''
                        } else {
                            if (response.data.msg) {
                                this.message = response.data.msg
                                return
                            } else {
                                console.log(response);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        

        addModalOn() {
            this.addModal = true
        }
    },
}
</script>

<style>
.md-m-l-10-percent{
            margin-left:10%;
        }
.notice{
    margin-top: 20px;
    padding-top: 10px;
}
.action-button{
    padding: 15px;
    margin: 15px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
    
}
.main_image_notice{
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
    max-width: 400px;
    max-height: 500px;
}
.details{
    padding: 5px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
}
.md-m-5{
    margin-left: 10%;
    margin-right: 10%;
}
@media (min-width: 320px) and (max-width: 767px) {
    .md-m-5{
        margin: 5%;
    } 
}
</style>