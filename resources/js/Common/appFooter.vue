<template>
    <!-- Footer -->
    <footer v-if="isAuthenticated && getuserinfo.role === 'Admin'">
        <v-layout class="overflow-visible hidden-sm-and-up" style="height: 56px;">
            <v-bottom-navigation v-model="value" grow style="background-color: #212121">
                <v-btn to="admin-panel" class="my-btn">
                    <v-icon color="#fff" >mdi-home</v-icon>
<!--                    <span style="color:#fff">Users & Usage</span>-->
                </v-btn>
                <v-btn to="refunded-queries" class="my-btn">
                    <v-icon color="#fff">mdi-help</v-icon>
<!--                    <span style="color:#fff">Refund Queried</span>-->
                </v-btn>
                <v-btn to="contacts-reviews" class="my-btn">
                    <v-icon color="#fff">mdi-information</v-icon>
<!--                    <span style="color:#fff">Reviews & Queries</span>-->
                </v-btn>
                <v-btn @click="showModal = true" class="my-btn">
                    <v-avatar size="40">
                        <img :src="image" style="height: 100%; width: 100%;" />
                    </v-avatar>
                </v-btn>
            </v-bottom-navigation>
        </v-layout>
    </footer>
    <footer v-else-if="isAuthenticated && getuserinfo.role === 'Company'">
        <v-layout class="overflow-visible hidden-sm-and-up" style="height: 56px;">
            <v-bottom-navigation v-model="value" grow style="background-color: #212121">
                <v-btn to="home" class="my-btn">
                    <v-icon color="#fff">mdi-home</v-icon>
                    <!--                        <span style="color:#fff">Home</span>-->
                </v-btn>
<!--                <v-btn to="Destination" class="my-btn">-->
<!--                    <v-icon color="#fff">mdi-map-marker</v-icon>-->
<!--                    &lt;!&ndash;                        <span style="color:#fff">Destination</span>&ndash;&gt;-->
<!--                </v-btn>-->
                <v-btn to="postad" class="my-btn">
                    <v-icon color="#fff">mdi-plus</v-icon>
                    <!--                        <span style="color:#fff">Post</span>-->
                </v-btn>
                <v-btn to="about" class="my-btn">
                    <v-icon color="#fff">mdi-information</v-icon>
                    <!--                        <span style="color:#fff">About Us</span>-->
                </v-btn>
                <v-btn @click="showModal = true" class="my-btn">
                    <v-avatar size="40">
                        <img
                            :src="image"
                            style="height: 100%; width: 100%;"
                        />
                    </v-avatar>
                </v-btn>
            </v-bottom-navigation>
        </v-layout>
    </footer>

    <footer v-else-if="isAuthenticated && getuserinfo.role === 'User'">
        <v-layout class="overflow-visible hidden-sm-and-up" style="height: 56px;">
                <v-bottom-navigation v-model="value" grow style="background-color: #212121">
                    <v-btn to="home" class="my-btn">
                        <v-icon color="#fff">mdi-home</v-icon>
<!--                        <span style="color:#fff">Home</span>-->
                    </v-btn>
                    <v-btn to="Destination" class="my-btn">
                        <v-icon color="#fff">mdi-map-marker</v-icon>
<!--                        <span style="color:#fff">Destination</span>-->
                    </v-btn>
                    <v-btn to="about" class="my-btn">
                        <v-icon color="#fff">mdi-information</v-icon>
<!--                        <span style="color:#fff">About Us</span>-->
                    </v-btn>
                    <v-btn @click="showModal = true" class="my-btn">
                        <v-avatar size="40">
                            <img
                                :src="image"
                                style="height: 100%; width: 100%;"
                            />
                        </v-avatar>
                    </v-btn>
                </v-bottom-navigation>
        </v-layout>
    </footer>
    <footer class="text-muted pt-4 app_footer " v-else>
        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            TRAVELBOO
                        </h6>
                        <p class="brand-disp">
                            Enjoy your travelling with <br> Travelboo
                        </p>
                    </div>
                    <!-- Grid column -->
                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6>
                        <div class="mb-2">
                            <router-link to="Home" class="footer-link">Home</router-link>
                        </div>
                        <div class="mb-2">
                            <router-link to="Destination" class="footer-link">Destination</router-link>
                        </div>
                        <div class="mb-2">
                            <router-link to="About" class="footer-link">About Us</router-link>
                        </div>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p class="color">
                            <v-icon color="#ffcc05">mdi-map-marker</v-icon>
                            SUPERIOR UNIVERSITY
                        </p>
                        <p>
                            <v-icon color="#ffcc05">mdi-email</v-icon>
                            <a href="mailto: sajeelsafdar99@gmail.com" class="footer-link">sajeelsafdar99@gmail.com</a>
                        </p>
                        <p class="color">
                            <v-icon color="#ffcc05">mdi-phone</v-icon>
                            +92 314 4293350
                        </p>
                        <p class="color">
                            <v-icon color="#ffcc05">mdi-phone</v-icon>
                            +92 312 4682504
                        </p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <div class="p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        ©2023 TRAVELBOO LTD. All rights reserverd
                    </div>
                    <div class="col-md-6 col-sm-6 d-flex justify-content-evenly">
                        <div>
                            <v-icon size="30px" color="#3b5998">mdi-facebook</v-icon>
                        </div>
                        <div>
                            <v-icon size="30px" color="#3f729b">mdi-instagram</v-icon>
                        </div>
                        <div>
                            <v-icon size="30px" color="#c8232c">mdi-pinterest</v-icon>
                        </div>
                        <div>
                            <v-icon size="30px" color="#075e54">mdi-whatsapp</v-icon>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </footer>
    <appAvatar :show="showModal" @close="closeModal"/>
    <div class="modal-backdrop fade show" v-if="showModal"></div>
    <!-- Footer -->
</template>

<script>

    import {mapGetters} from "vuex";
    import AppAvatar from "../Components/pages/appAvatar";

    export default {
        name: "appFooter",
        data: () => ({
            value: 1, showModal: false,
        }),
        components: {AppAvatar},
        computed: {
            // check if user is authenticated and return true or false
            ...mapGetters(['isAuthenticated', "getuserinfo"]),
            avatarUrl() {
                return `https://randomuser.me/api/portraits/women/81.jpg`;
            },
            userinfo() {
                return this.getuserinfo;
            },
            image() {
                return this.userinfo.image ? this.userinfo.image : 'storage/avatar/default.png';
            },
        },
        methods: {
            closeModal() {
                this.showModal = false;
            },
        }
    }

</script>

<style scoped>

    .color {
        color: #ffffff;
    }

    .app_footer {
        background-color: #1c1c1c;
    }

    .brand-disp {
        color: #ffffff;
    }

    .footer-link {
        text-decoration: none;
        color: #ffffff;
    }

    h6 {
        color: #ffffff
    }

    footer {
        z-index: 1;
        position: relative;
    }

</style>
