<template>
    <div>
        <div>
            <h1 class="custom_h1 text-center">UPCOMING HOLIDAY NOTICES</h1>
            <div v-for="(item,index) in notice" :key="index">
                <img class="image_2" :src="item.image" alt=""> 
            </div>
            <div class="main_image_2">
                <a href="/common-notices" class="custom_button btn btn-secondary">View All</a>
            </div>
        </div>
         
       
        <div class="main_image">
            <h1 class="custom_h1 text-center">HONORABLE FACULTY MEMBERS</h1>
            <div class="d-f">
                <div v-for="(item,index) in teacher" :key="index">
                    <img class="img_3" src="/images/avatar.png" alt=""> 
                    <b>{{item.name}}</b>
                    <br>
                    <b>{{item.email}}</b>
                    <br>
                    <b>{{item.department}}</b>
                </div>
            </div>
                
           <a href="/teachers?department=All" class="custom_button btn btn-secondary">View All</a>
        </div>

    </div>
</template>
<script>
import {ref} from 'vue';
export default {
    data(){
        return {
            active: ref(0),
            slideIndex:1,
            notice:[],
            teacher:[],
        }
    },
    created(){
        this.loadEvenets()
    },
   
    methods:{
        loadEvenets(){
            this.$axios.get('/api/notices/home')
                    .then(response => {
                        if (response.data) {
                            this.notice = response.data.notice
                            this.teacher = response.data.teacher
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
        }
        
    }
}
</script>

<style>
    .d-f{
        display: flex;
    }
    .img_3{
        padding-bottom: 15px;
        padding-right: 20px;
        max-width: 180px;
    }
    .main_image{
        margin-top: 40px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
    .main_image_2{
        margin-top: 10px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
    .image_2{
        margin-left: 430px;
    }
   
    .custom_button{
        margin-left: 235px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    .custom_h1{
        margin-bottom: 20px;
    }
</style>