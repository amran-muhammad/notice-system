<template>
    <div>
        <TopSection />
        <Landing />
        <Footer />
    </div>
</template>

<script>
import TopSection from '../components/TopSection.vue';
import Footer from '../components/Footer.vue';
import Landing from '../components/Landing.vue';
export default {
    name: "Home",
    components: {
        TopSection,
         Footer,
         Landing
    }   
}
</script>