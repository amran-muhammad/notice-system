<template>
    <main>
      <div class="formula">
        <div class="mb-3">
            <h1 style="margin-bottom:40px" class="text-center">UPCOMING NOTICES</h1>
        </div>
    </div>
    <div v-for="(item,index) in notice" :key="index">
        <img class="mob-notice" :src="item.image" alt=""> 
    </div>
    <div class="formula">
        <button @click="go_to_all_notice()" class="btn btn-secondary btn-lg submit">View All</button>
    </div>
  
      <section class="pricing" id="pricing">
        <h1 class="text-center" style="margin-bottom:40px">HONORABLE FACULTY MEMBERS</h1>
  
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
  
          <div class="col col-lg-4 col-md-6 card"  v-for="(item, index) in teacher" :key="index">
                <img class="card-img-top" :src="item.image" alt="Card image cap">
                <div class="card-body">
                    <h6>{{ item.name }}</h6>
                    <h6>Email: {{ item.email }}</h6>
                    <p>Program: {{ item.course }}</p>
                    <p>Department: {{ item.department }}</p>
                    
                </div>
          </div>
          <button @click="go_to_all_teacher()" class="btn btn-secondary btn-lg submit_2">View All</button>

  
        </div>
  
      </section>
  
    </main>
  
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
        go_to_all_teacher(){
            this.$router.push('/teachers?department=All')
        },
        go_to_all_notice(){
            this.$router.push('/common-notices')
        },
        loadEvenets(){
            this.$axios.get('/api/notices/home')
                .then(response => {
                    if (response.data) {
                        this.notice = response.data.notice
                        if(this.notice.length==0){
                            this.notice.push({
                                image:'/images/default.jpg'
                            })
                        }
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
* {
  font-family: "Quicksand", sans-serif;
}
.mob-notice{
    margin-left:30%;
    min-width: 600px;
  }
/* Header */

header {
  position: fixed;
  width: 100%;
  top: 0;
}

#header-img {
  border-radius: 100%;
}

.navbar {
  padding: 20px;
  font-size: large;
}

/* Main */

main {
  margin-top: 15px;
}

/* Form*/

.formula {
  width: 400px;
  margin: 40px auto;
}

.submit {
  width: 60%;
  margin-left: 15%;
}
.submit_2 {
  margin-top: 20px;
  width: 14%;
  margin-left: 44%;
}



/* Pricing */

.pricing {
  margin: 40px 20%;
}

.card {
  z-index: -1;
}

.card-title {
  font-size: xx-large;
  font-weight: 800;
  color: grey;
}

@media (max-width: 1028px) {
  header {
    text-align: center;
  }
}
/* Mobile to Tablet  */
@media (min-width: 320px) and (max-width: 767px) {
  .submit {
    margin-top: 20px;
    width: 40%;
    margin-left: 30%;
  }
  .mob-notice{
    margin-left: 15%;
    margin-right: 15%;
  }
}

/* Tablet to Desktop */
@media (min-width: 768px) {
  .submit {
    margin-top: 20px;
    width: 40%;
    margin-left: 30%;
  }
}


</style>
