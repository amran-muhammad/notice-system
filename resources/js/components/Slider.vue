<template>
    <div>
        <div>
            <h1 class="custom_h1 text-center">UPCOMING NOTICES</h1>
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
                    <div class="card" style="width: 35rem;" v-for="(item, index) in teacher" :key="index">
                        <img class="card-img-top" :src="item.image" alt="Card image cap">
                        <div class="card-body">
                            <h6>{{ item.name }}</h6>
                            <h6>Email: {{ item.email }}</h6>
                            <p>Course: {{ item.course }}</p>
                            <p>Department: {{ item.department }}</p>
                            
                        </div>
                    </div>
                </div>
                
           <a href="/teachers?department=All" class="custom_button2 btn btn-secondary">View All</a>
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

<style scoped>
    .d-f{
        display: flex;
        margin-left: 20px;
    }
    .img_3{
        padding-bottom: 15px;
        padding-right: 20px;
        max-width: 150px;
        max-height: 200px;
    }
    .main_image{
        margin-top: 40px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        margin-bottom: 20px;
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
        max-width: 400px;
        max-width: 400px;
    }
   
    .custom_button{
        margin-left: 235px;
        /* margin-top: 20px;
        margin-bottom: 20px; */
    }
    .custom_button2{
        margin-left: 280px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    
    .custom_h1{
        margin-bottom: 20px;
    }
</style>