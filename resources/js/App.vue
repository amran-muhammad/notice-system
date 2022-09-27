<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">University Notice System</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="navbar-nav" v-if="isLoggedIn">
                <router-link to="/" class="nav-item nav-link">Home</router-link>
                <router-link to="/events" class="nav-item nav-link">Events</router-link>
                <router-link to="/complains" class="nav-item nav-link">Complains</router-link>
                <router-link to="/common-notices" class="nav-item nav-link">Common Notices</router-link>
                <router-link to="/notices" class="nav-item nav-link">Notices</router-link>
                <router-link to="/teachers" class="nav-item nav-link">Techers</router-link>
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
                name:''
            }
        },
        created() {
            if (window.Laravel.isLoggedin) {
                this.isLoggedIn = true
                this.type = window.Laravel.user.type
                this.name = window.Laravel.user.name
            }
        },
        methods: {
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