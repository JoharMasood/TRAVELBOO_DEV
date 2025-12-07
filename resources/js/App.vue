<template>
    <div>
        <app-header></app-header>
        <app-footer></app-footer>
        <Snackbar :message="message" :color="color" v-if="message"/>
    </div>
</template>

<script>

import AppHeader from "./Common/appHeader";
import AppFooter from "./Common/appFooter";
import Snackbar from "./Components/pages/Snackbar";
export default {
    name: "App",
    components: {AppFooter, AppHeader, Snackbar},
    computed: {
        message() {
            return this.$store.getters.getmessage;
        },
        color(){
            return this.$store.getters.getcolor;
        }
    }
};
</script>

<style scoped>


</style>
