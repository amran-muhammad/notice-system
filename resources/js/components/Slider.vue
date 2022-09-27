<template>
    <div id="carouselExampleControls" class="main_image carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div v-for="(item,index) in events" :key="index">
                <div :class="index==active ? 'carousel-item active': 'carousel-item'">
                    <img class="d-block w-100" :src="item.image" alt="First slide">
                </div>
            </div>
            
        </div>
        <a @click="changeActive(-1)" class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a @click="changeActive(1)" class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</template>
<script>
import {ref} from 'vue';
export default {
   
    data(){
        return {
            active: ref(0),
            slideIndex:1,
            events:[]
        }
    },
    created(){
        this.loadEvenets()
    },
   
    methods:{
        changeActive(n){
            if(this.active == 0 && n == -1) this.active = this.events.length - 1
            else if(n == -1) this.active = this.active - 1
            else if(this.active == 0 && n == 1) this.active = this.active + 1
            else if(this.active == this.events.length - 1 && n == 1) this.active = this.active - 1
            else if(n == 1) this.active = this.active + 1
        },
 
        loadEvenets(){
            this.$axios.get('/api/events/all')
                    .then(response => {
                        if (response.data.data) {
                            this.events = response.data.data
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
.main_image{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>