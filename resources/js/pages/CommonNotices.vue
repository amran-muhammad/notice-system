<template>
    <div class="row" style="margin-top:20px;">
        <Modal v-model="deleteModal" title="Are you sure delete the notice?" @on-ok="deleteNotice"
            @on-cancel="deleteModal = false" ok-text="Confirm" draggable sticky loading>

        </Modal>
        <Modal v-model="editStatusModal" title="Are you sure update the status?" @on-ok="updateNoticeStatus"
            @on-cancel="editStatusModal = false" ok-text="Confirm" draggable sticky loading>

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
        
        <br>
        <div class="notice" v-for="(item, index) in notices" :key="index">
            <img class="main_image_common" :src="item.image" alt="no photo">
            <table class="table table-striped custom_table">
                    <thead>
                        <tr>
                            <th scope="col" class="custom_title">Title</th>
                            <th scope="col" v-if="user.type=='Admin' || user.type=='Teacher'">Status</th>
                            <th scope="col" class="custom_title">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row custom_title"> <span>{{item.title}}</span>  </th>
                        <th scope="row" v-if="user.type=='Admin' || user.type=='Teacher'"> <span>{{item.status}}</span>  </th>
                        <th scope="row custom_title" style="display: flex">
                            <div v-if="user.type=='Admin'">
                                <button v-if="item.status == 'Pending' || item.status == null" class="btn btn-sm btn-success"
                                        @click="editStatusModalOn(item, index)">Approve</button>
                                    <button v-else class="btn btn-sm btn-info"
                                        @click="editStatusModalOn(item, index)">x</button>
                            </div>

                                <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-secondary"
                                        @click="editNotice(item, index)"><i class="fa fa-edit"></i></button>
                                <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-danger"
                                        @click="deleteNoticeOn(item, index)"><i class="fa fa-trash"></i></button>
                                <a :href="item.image" download style="margin-left:5px;"  class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                        </th>
                        </tr>
                    </tbody>
                </table>
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
            editStatusModal: ref(false),
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
                status: '',
            },
            edit_data: {
                id: '',
                class_name: '',
                department_name: '',
                section: '',
                title: '',
                image: '',
                status: '',
            },
            search_data: {
                class_name: '',
                department_name: '',
                section: '',
            },
            limit: ref(0),
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
        editStatusModalOn(item, index) {
            this.editStatusModal = true
            this.editIndex = index
            this.edit_data.id = item.id
            this.edit_data.status = item.status == 'Approved' ? 'Pending' : 'Approved'
        },
        updateNoticeStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/notices/update/data', { id: this.edit_data.id, status: this.edit_data.status })
                    .then(response => {
                        if (response.data.data) {
                            this.editStatusModal = false
                            this.notices[this.editIndex].id = response.data.data.id
                            this.notices[this.editIndex].status = response.data.data.status
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
                this.$axios.get('/api/notices/all')
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
    .main_image_common{
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
    @media (min-width: 320px) and (max-width: 767px) {
        .custom_table{
            margin-left: 5%;
            max-width:390px;
           min-width:390px;
        }
        .custom_title{
            max-width:100px;
            min-width:100px;
        }
    }
    @media (min-width: 1200px) and (max-width: 1421px) {
        .main_image_common {
            display: block;
            width: 50%;
            max-width: 400px;
            max-height: 500px;
            margin-left: 28%;
        }
        .custom_table{
           margin-left:10%;
           max-width:900px;
           min-width:900px;
        }
        .custom_title{
            max-width:665px;
            min-width:665px;
        }
    }
    @media (min-width: 1422px) and (max-width: 1921px) {
        .main_image_common {
            display: block;
            width: 96%;
            max-width: 750px;
            max-height: 500px;
            margin-left: 21%;
        }
        .custom_table{
           margin-left:17%;
           max-width:900px;
           min-width:900px;
        }
        .custom_title{
            max-width:665px;
            min-width:665px;
        }
    }
   
</style>