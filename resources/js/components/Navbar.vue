<template>
  <header>
    <nav>
      <div id="navbar">
        <div id="logo" class="reverse">
          <div class="mobile-btn" style="font-size:30px;cursor:pointer; font-weight:bold;" @click="openNav()">&#9776;</div>
          <a href="/" class="logo"><img class="logo-img" src="../../../assets/logo.png" alt=""></a>

        </div>
        <div id="links">
          <router-link to="/" v-if="isLoggedIn">Home</router-link>
          <router-link to="/events" v-if="isLoggedIn">Events</router-link>
                <router-link @click="updateNotification()" to="/complains" v-if="isLoggedIn && type !='Teacher'">Complains <span v-if="notification" class="dot"></span></router-link>
                <router-link to="/common-notices" v-if="isLoggedIn">Common Notices</router-link>
                <router-link to="/notices" v-if="isLoggedIn">Notices</router-link>
                    <div @mouseover="myFunction()" @mouseout="myFunction()" class="dropdown" v-if="isLoggedIn">
                        <a>Teachers</a>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/teachers?department=CSE">Department of CSE</a>
                            <a href="/teachers?department=BBA">Department of BBA</a>
                            <a href="/teachers?department=EEE">Department of EEE</a>
                            <a href="/teachers?department=English">Department of English</a>
                        </div>
                    </div>
                <router-link v-if="isLoggedIn && type=='Admin'" to="/students">Students</router-link>
                
                <router-link v-if="isLoggedIn" to="/profile">{{ type }} Profile ({{name}})</router-link>
                <a v-if="isLoggedIn" style="cursor: pointer;" @click="logout">Logout</a>
                <router-link v-if="!isLoggedIn" to="/">Home</router-link>
                <router-link v-if="!isLoggedIn" to="/login">Login</router-link>
                <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
        </div>
      </div>

    </nav>
    <!-- Mobile Menu -->
    <div id="mySidenav" class="sidenav">
      <a style="cursor:pointer;" class="closebtn" @click="closeNav()">&times;</a>
      <router-link to="/" v-if="isLoggedIn">Home</router-link>
          <router-link to="/events" v-if="isLoggedIn">Events</router-link>
                <router-link @click="updateNotification()" to="/complains" v-if="isLoggedIn && type !='Teacher'">Complains <span v-if="notification" class="dot"></span></router-link>
                <router-link to="/common-notices" v-if="isLoggedIn">Common Notices</router-link>
                <router-link to="/notices" v-if="isLoggedIn">Notices</router-link>
                    <div v-if="isLoggedIn">
                        <a @click="myFunctionMobile()">Teachers</a>
                        <div v-if="departmentsMobileOptions">
                            <a href="/teachers?department=CSE">Department of CSE</a>
                            <a href="/teachers?department=BBA">Department of BBA</a>
                            <a href="/teachers?department=EEE">Department of EEE</a>
                            <a href="/teachers?department=English">Department of English</a>
                        </div>
                    </div>
                <router-link v-if="isLoggedIn && type=='Admin'" to="/students">Students</router-link>
                
                <router-link v-if="isLoggedIn" to="/profile">{{ type }} Profile ({{name}})</router-link>
                <a v-if="isLoggedIn" style="cursor: pointer;" @click="logout">Logout</a>
                <router-link v-if="!isLoggedIn" to="/">Home</router-link>
                <router-link v-if="!isLoggedIn" to="/login">Login</router-link>
                <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
    </div>
  </header>
  
  
</template>
<script>
import { ref } from 'vue';
import { Notyf } from 'notyf';
export default {
    data() {
            return {
                isLoggedIn: false,
                type:'',
                name:'',
                area_collaps: false,
                notification: false,
                departmentsMobileOptions: ref(false),
                new_total: 0,
                notyf:new Notyf()
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
            
            myFunctionMobile() {
                this.departmentsMobileOptions = !this.departmentsMobileOptions
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
                          this.notyf.success("You are logging out!")
                            window.location.href = "/"
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                })
            },
      
 
            openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            },

            closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        }
}
</script>

<style scoped>
.logo-img{
  max-width: 100px;
  max-height: 85px;
  margin: 5px;
}
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
#navbar {
  display: grid;
  min-height: 100px;
  grid-auto-flow: column;
  background-color: #fcfcfc;
  grid-gap: 1.5em;
  padding: 0 40px;
  -webkit-box-shadow: -1px 4px 5px 0px rgba(209, 205, 209, 1);
  -moz-box-shadow: -1px 4px 5px 0px rgba(209, 205, 209, 1);
  box-shadow: -1px 4px 5px 0px rgba(209, 205, 209, 1);
}

#logo {
  display: grid;
  justify-content: start;
  align-content: center;
  font-family: "Open Sans", sans-serif;
  font-size: 30px;
  font-weight: 700;
  color: #000;
  text-transform: uppercase;
}

.logo span {
  color: #0474bc;
}

#links {
  display: grid;
  justify-content: right;
  align-content: center;
  grid-auto-flow: column;
  grid-gap: 1.5em;
  font-family: "Open Sans", sans-serif;
}

#links a {
  text-decoration: none;
  color: #333;
  text-transform: uppercase;
  font-weight: bold;
}

#links a:hover {
  color: #0474bc;
}

/* =======================
******* Mobile Menu ******
========================*/
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #fff;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

a {
  font-family: "Open Sans", sans-serif;
}

/* Mobile to Tablet  */
@media (min-width: 320px) and (max-width: 767px) {
  #links,
  .mobile-menu {
    display: none;
  }
  #logo {
    display: inline-grid;
    grid-template-columns: auto auto;
    grid-gap: 70px;
  }
}

/* Tablet to Desktop */
@media (min-width: 768px) {
  .mobile-btn {
    display: none;
  }
}

</style>






