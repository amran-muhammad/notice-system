<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">University Notice System</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/" class="nav-item nav-link">Home</router-link>
                <router-link to="/events" class="nav-item nav-link">Events</router-link>
                <router-link @click="updateNotification()" to="/complains" class="nav-item nav-link">Complains <span v-if="notification" class="dot"></span></router-link>
                <router-link to="/common-notices" class="nav-item nav-link">Common Notices</router-link>
                <router-link to="/notices" class="nav-item nav-link">Notices</router-link>
                    <div class="dropdown">
                    <a @click="myFunction()" class="nav-item nav-link" >Department</a>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="/teachers?department=CSE">Department of CSE</a>
                        <a href="/teachers?department=BBA">Department of BBA</a>
                        <a href="/teachers?department=EEE">Department of EEE</a>
                        <a href="/teachers?department=English">Department of English</a>
                    </div>
                    </div>
            </div>
            <div class="navbar-nav" v-if="isLoggedIn && type=='Admin'">
                <router-link to="/students" class="nav-item nav-link">Students</router-link>
            </div>
            
            
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/profile" class="nav-item nav-link">{{ type }} Profile ({{name}})</router-link>
                <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
            </div>
            <div class="navbar-nav" v-else>
                <router-link to="/" class="nav-item nav-link">Home</router-link>
                <router-link to="/login" class="nav-item nav-link">Login</router-link>
                <router-link to="/register" class="nav-item nav-link">Register</router-link>
            </div>
        </nav>


        <router-view></router-view>
    </div>
</template>
<script>
    export default {
        name: "App",
        data() {
            return {
                isLoggedIn: false,
                type:'',
                name:'',
                area_collaps: false,
                notification: false,
                new_total: 0,
            }
        },
        created() {
            if (window.Laravel.isLoggedin) {
                this.isLoggedIn = true
                this.type = window.Laravel.user.type
                this.name = window.Laravel.user.name

                let old_total = localStorage.getItem('old_total') ? localStorage.getItem('old_total') : 0
                this.check_notification(old_total)
            }
        },
        
        methods: {
            updateNotification(){
                localStorage.setItem('old_total',this.new_total)
                this.notification = false
            },
            check_notification(old_total) {
                this.$axios.get('/api/complains/count?old_total='+old_total)
                    .then(response => {
                        if (response.data.data) {
                            this.notification = response.data.data
                            this.new_total = response.data.new_total
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            },

            myFunction() { 
                document.getElementById("myDropdown").classList.toggle("show");
            },
            setAreaCol(){
                this.area_collaps=!this.area_collaps
                console.log(this.area_collaps)
            },
            logout(e) {
                e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/logout')
                    .then(response => {
                        if(response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                })
            }
        },
    }


</script>

<style>
.dot {
  height: 5px;
  width: 5px;
  margin-bottom: 2px;
  background-color: rgb(214, 21, 21);
  border-radius: 50%;
  display: inline-block;
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #bbb;}

.show {display: block;}
</style>