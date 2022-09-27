<template>
    <div class="row">
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

        <h1>Notices</h1>

        <div v-if="user.type=='Teacher' || user.type=='Admin'" class="col-md-6">
            <div>
                <button @click="addModalOn()" class="btn btn-sm btn-secondary">Add New Notice</button>
            </div>
        </div>
        
        <br>
        <div class="notice" v-for="(item, index) in notices" :key="index">
            <img class="main_image" :src="item.image" alt="no photo">
            <div class="action-button">
                <h5>{{item.title}}</h5>
            </div>
   
            <div class="action-button" v-if="user.type=='Teacher' || user.type=='Admin'">
                <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-secondary"
                        @click="editNotice(item, index)">Edit</button>
                    <button v-if="user.id==item.user_id || user.type=='Admin'" style="margin-left:5px" class="btn btn-sm btn-danger"
                        @click="deleteNoticeOn(item, index)">Delete</button>
            </div>
            <div class="action-button">
                <a :href="item.image" download class="btn btn-primary">Download</a>
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
        }
    },
    created() {
        this.get_all_notices()
        if (window.Laravel.user) {
            this.user = window.Laravel.user
        }
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
    .notice{
        margin-top: 20px;
        padding-top: 10px;
        border: 2px solid rgb(106, 136, 141)
    }
    .action-button{
        padding: 15px;
        margin: 15px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        
    }
    .main_image{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
    .details{
        padding: 5px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>