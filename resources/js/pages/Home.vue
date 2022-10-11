<template>
    <div>
        <TopSection />
        <!-- <Slider /> -->
        <Landing />
        <Footer />
    </div>
</template>

<script>
import TopSection from '../components/TopSection.vue';
// import Slider from '../components/Slider.vue';
import Footer from '../components/Footer.vue';
import Landing from '../components/Landing.vue';
export default {
    name: "Home",
    components: {
        TopSection,
        //  Slider,
         Footer,Landing
    }   
}
</script>