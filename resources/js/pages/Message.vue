<template>
   <div :class="user.type=='Admin' ? 'chat-container-main':'chat-container'">
     <div v-if="user.type=='Admin'" class="user-sidebar">
      <ul class="user-list">
        <li class="user-list-item">Teacher List</li>
        <li v-for="(item,index) in teachers" :key="index" @click="setReceiver(item.id)" :class="form_data.receiver == item.id ? 'active':''" class="user-list-item">{{item.name}}</li>
        <!-- Add more users here -->
      </ul>
    </div>
    <div :class="user.type=='Admin' ? 'chat-container-second':''">
        <div class="chat-messages">
      <div v-for="(item,index) in chats" :key="index">
        <div v-if="user.id==item.sender" class="chat-message sender-message">
            <div class="message-content">{{item.message}}</div>
        </div>
        <div v-if="user.id==item.receiver" class="chat-message receiver-message">
            <div class="message-content">{{item.message}}</div>
        </div>
        <br>
    </div>
    </div>
    <div class="chat-input-container">
      <input v-model="form_data.message" type="text" class="chat-input" placeholder="Type your message..." />
      <button @click="createChat" class="send-button">Send</button>
    </div>
    </div>
  </div>
</template>
<script>
import { Notyf } from 'notyf';
export default {
    name: "Notices",
    data() {
        return {
            chats: [],
            teachers: [],
            form_data: {
                message: '',
                receiver: '',
            },
            user: {},
            notyf:new Notyf()
        }
    },
    created() {
        if (window.Laravel.user) {
            this.user = window.Laravel.user
            Promise.all([this.get_all_teacher(),this.getChats()])
        }
    },
    
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.user) {
            window.location.href = "/login";
        }
        next();
    },
   
    methods: {
        setReceiver(id){
            this.form_data.receiver = id
            this.getChats()
        },
        get_all_teacher() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/teachers/chat/all')
                    .then(response => {
                        if (response.data.data) {
                            this.teachers = response.data.data
                            this.form_data.receiver = this.teachers[0].id
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        getChats() {
            let url = ""
            if(this.user.type == "Teacher"){
                url = "/api/chats/get"
            }else{
                url = "/api/chats/admin/get"
                if(this.form_data.receiver){
                    url = url+"?teacher="+this.form_data.receiver
                }
            }
          
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(url,this.search_data)
                    .then(response => {
                        if (response.data.data) {
                            this.chats = response.data.data
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        createChat() {
            if (this.form_data.message == '') {
                return
            }
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                if(this.user.type == "Teacher"){
                    this.form_data.receiver = "Admin"
                }
                else if(this.form_data.receiver == ''){
                    this.notyf.error("Please select a teacher!")
                }
                this.$axios.post('/api/chats/create', this.form_data)
                    .then(response => {
                        if (response.data.data) {
                            this.chats.push(response.data.data)
                            this.form_data.message = ''
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
    body {
      font-family: Arial, sans-serif;
    }

    .chat-container {
      display: flex;
      flex-direction: column;
      width: 800px;
      margin: 20px auto;
      border: 1px solid #ccc;
      border-radius: 5px;
      overflow: hidden;
    }
    .chat-container-second {
      display: flex;
      flex-direction: column;
      width: 800px;
      border: 1px solid #ccc;
      border-radius: 5px;
      overflow: hidden;
    }
    .chat-container-main {
      display: flex;
      width: 800px;
      margin: 20px auto;
      border: 1px solid #ccc;
      border-radius: 5px;
      overflow: hidden;
    }

    .user-sidebar {
      width: 200px;
      background-color: #f9f9f9;
      padding: 10px;
    }

    .user-list {
      list-style-type: none;
      padding: 0;
    }

    .user-list-item {
      padding: 5px;
      border-bottom: 1px solid #ccc;
    }
    .user-list-item.active {
      background-color: #e6f7ff;
    }

    .user-list-item:last-child {
      border-bottom: none;
    }

    .chat-messages {
      flex: 1;
      height: 300px;
      overflow-y: scroll;
      padding: 10px;
    }

    .chat-message {
      margin-bottom: 10px;
      padding: 5px;
      border-radius: 5px;
    }

    .sender-message {
      background-color: #d9f1ff;
      float: right;
      clear: both;
    }

    .receiver-message {
      background-color: #f1f1f1;
      float: left;
      clear: both;
    }

    .message-content {
      word-wrap: break-word;
    }

    .chat-input-container {
      display: flex;
      align-items: center;
      border-top: 1px solid #ccc;
      padding: 10px;
    }

    .chat-input {
      flex: 1;
      padding: 10px;
      border: none;
    }

    .send-button {
      width: 70px;
      height: 40px;
      background-color: #4CAF50;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      margin-left: 10px;
      cursor: pointer;
    }
  </style>