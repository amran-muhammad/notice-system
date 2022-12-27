<template>
  <main>
    <marquee>Dear students, the supplie exam will be held in January 2023.
      Please pay your exam fee before 16 Dec, 2022. <span style="padding-left: 40px"></span> Dear students, University
      class has been closed in 16 Dec, 2022.
      Apply your art / writing paper before 13 Dec, 2022.
    </marquee>
    <div class="formula">
      <div class="mb-3">
        <h1 style="margin-bottom:40px" class="text-center">UPCOMING NOTICES</h1>
      </div>
    </div>
    <div v-if="notice.length > 0">
      <div v-for="(item, index) in notice" :key="index">
        <img class="notice_big" :src="item.image" alt="">
      </div>
    </div>
    <div v-else>
      <img class="notice_big" src="../../../assets/default.jpg" alt="">
    </div>
    <div class="formula">
      <button @click="go_to_all_notice()" class="btn btn-secondary btn-lg submit">View All</button>
    </div>

    <section class="pricing" id="pricing">
      <h1 class="text-center" style="margin-bottom:40px">HONORABLE FACULTY MEMBERS</h1>

      <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">

        <div class="col col-lg-4 col-md-6 card" v-for="(item, index) in teacher" :key="index">
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
import { ref } from 'vue';
export default {
  data() {
    return {
      active: ref(0),
      slideIndex: 1,
      notice: [],
      teacher: [],
    }
  },
  created() {
    this.loadEvenets()
  },

  methods: {
    go_to_all_teacher() {
      this.$router.push('/teachers?department=All')
    },
    go_to_all_notice() {
      this.$router.push('/common-notices')
    },
    loadEvenets() {
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
* {
  font-family: "Quicksand", sans-serif;
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
    margin-left: 27%;
  }

  .submit_2 {
    margin-top: 20px;
    width: 58%;
    margin-left: 19%;
  }

  .notice_big {
    margin-left: 15%;
    margin-right: 15%;
    max-width: 268px;
    max-height: 180px;
  }

  .text-center {
    margin-right: 6%;
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

/* Tablet to Desktop */
@media (min-width: 1200px) and (max-width: 1599px) {
  .notice_big {
    margin-left: 29%;
    min-width: 590px;
    max-width: 590px;
  }

  .submit_2 {
    margin-top: 20px;
    width: 21%;
    margin-left: 41%;
  }
}

@media (min-width: 1919px) {
  .submit_2 {
    margin-top: 20px;
    width: 14%;
    margin-left: 44%;
  }

  .notice_big {
    margin-left: 30%;
    min-width: 750px;
    max-width: 750px;
  }
}
</style>
