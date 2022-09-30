<template>
    <div>
        <TopSection />
        <Slider />
        <Footer />
    </div>
</template>

<script>
import TopSection from '../components/TopSection.vue';
import Slider from '../components/Slider.vue';
import Footer from '../components/Footer.vue';
export default {
    name: "Home",
    components: {
        TopSection, Slider, Footer
    }   
}
</script>