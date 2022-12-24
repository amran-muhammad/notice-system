<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the event?" @on-ok="deleteNotice"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="addModal" title="Add New Event" @on-ok="addNotice" @on-cancel="addModal = false"
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
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Description</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="form_data.description" required autofocus
                                        autocomplete="off" placeholder="Enter descrption"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Start Date</label>
                                <div class="col-md-8">
                                    <input id="form_start_date" :min="new Date().toISOString().substr(0, 10)" type="date" class="form-control" v-model="form_data.start_date" required autofocus
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">End Date</label>
                                <div class="col-md-8">
                                    <input id="form_end_date" :min="new Date().toISOString().substr(0, 10)" type="date" class="form-control" v-model="form_data.end_date" required autofocus
                                        autocomplete="off">
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
        <Modal v-model="editModal" title="Edit Event" @on-ok="updateNotice" @on-cancel="editModal = false"
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
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Description</label>
                                <div class="col-md-8">
                                    <textarea id="name" type="text" class="form-control" v-model="edit_data.description" required autofocus
                                        autocomplete="off" placeholder="Enter descrption"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Start Date</label>
                                <div class="col-md-8">
                                    <input id="edit_start_date" :min="new Date().toISOString().substr(0, 10)" type="date" class="form-control" v-model="edit_data.start_date" required autofocus
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">End Date</label>
                                <div class="col-md-8">
                                    <input id="edit_end_date"  :min="new Date().toISOString().substr(0, 10)" type="date" class="form-control" v-model="edit_data.end_date" required autofocus
                                        autocomplete="off">
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

        <h1 class="md-m-l-10-percent" >Events</h1>

        <div v-if="user.type=='Admin'" class="col-md-6 md-m-l-10-percent">
            <div>
                <button @click="addModalOn()" class="btn btn-sm btn-secondary">Add New Event</button>
            </div>
        </div>
       
            

        <br>
        <div class="notice" v-for="(item, index) in notices" :key="index">
            <img class="main_image_event" :src="item.image" alt="no photo">
            <div class="details">
                <table class="table md-m-5">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row"> <span>{{item.title}}</span>  </th>
                        <td> <span v-if="item.start_date" >{{item.start_date}} </span></td>
                        <td> <span v-if="item.end_date" >{{item.end_date}} </span></td>
                        <td> <span v-if="item.description" >{{item.description}} </span></td>
                        <td>
                            <button v-if="user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-secondary"
                                @click="editNotice(item, index)"><i class="fa fa-edit"></i></button>
                            <button v-if="user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-danger"
                                    @click="deleteNoticeOn(item, index)"><i class="fa fa-trash"></i></button>
                                <a :href="item.image" download style="margin-left:5px;"  class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
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
    name: "Events",
    data() {
        return {
            deleteModal: ref(false),
            addModal: ref(false),
            editModal: ref(false),
            notices: [],
            form_data: {
                start_date: '',
                end_date: '',
                description: '',
                title: '',
                image: '',
            },
            edit_data: {
                start_date: '',
                end_date: '',
                description: '',
                title: '',
                image: '',
                id: '',
            },
            user: {},
            message: ref(''),
        }
    },
    created() {
        this.get_all_notices()
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
                this.$axios.post('/api/events/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
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
                this.$axios.post('/api/events/file-upload',form_image,{headers: { 'content-type': 'multipart/form-data' }})
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
        get_all_notices() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/events/all')
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
            else if (this.form_data.description == '') {
                this.message = 'Select a department name'
                return
            }
            else if (this.form_data.start_date == '') {
                this.message = 'Select a start date'
                return
            }
            else if (this.form_data.end_date == '') {
                this.message = 'Select a end date'
                return
            }
            else if (this.form_data.image == '') {
                this.message = 'Please provide a event image link'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/events/create', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.addModal = false
                            this.notices.unshift(response.data.data)
                            this.form_data.class_name = ''
                            this.form_data.description = ''
                            this.form_data.start_date = ''
                            this.form_data.end_date = ''
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
            this.notice_type = ''
            if(item.description){
                this.notice_type = 'Specific'
            }
            this.editModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.description = item.description
            this.edit_data.start_date = item.start_date
            this.edit_data.end_date = item.end_date
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
                this.$axios.post('/api/events/delete', {
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
            else if (this.edit_data.description == '') {
                this.message = 'Select a department name'
                return
            }
            else if (this.edit_data.start_date == '') {
                this.message = 'Select a start date'
                return
            }
            else if (this.edit_data.end_date == '') {
                this.message = 'Select a end date'
                return
            }
            else if (this.edit_data.image == '') {
                this.message = 'Please provide a event image link'
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put('/api/events/update', this.edit_data)
                    .then(response => {
                        if (response.data.data) {
                            this.editModal = false
                            this.notices[this.editIndex] = response.data.data
                            this.edit_data.title = ''
                            this.edit_data.description = ''
                            this.edit_data.start_date = ''
                            this.edit_data.end_date = ''
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
        },
    },
}
</script>

<style>
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
    .main_image_event{
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

    .md-m-l-10-percent{
            margin-left:10%;
        }
    @media (min-width: 320px) and (max-width: 767px) {
        td{
            max-width:150px;
            word-wrap:break-word;
        }
        
        .main_image_event {
            display: block;
            max-width: 400px;
            max-height: 500px;
        }
        .md-m-5{
            margin: 5%;
        }
        .md-m-l-20{
            margin-left: 20px;
        }
        
    }
</style>