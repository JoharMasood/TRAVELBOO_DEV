<template>
    <template v-if="isAuthenticated && isHiddenXsAndDown" >
        <v-card>
            <v-layout>
                <v-navigation-drawer
                    permanent
                    location="left"
                    class="hidden-md-and-down "
                    theme="dark"
                >
                    <template v-slot:prepend>
                        <v-list-item
                            lines="two"
                            :prepend-avatar="image || defaultImage"
                            :title="`${capitalizeFirstLetter(firstname)} ${capitalizeFirstLetter(lastname)}`"
                            @click="showModal = true"
                        ></v-list-item>
                    </template>

                    <v-divider></v-divider>

                    <v-list density="compact" nav v-if="getuserinfo.role === 'Admin'">
                        <v-list-item prepend-icon="mdi-home" title="Users & Usage" value="home" to="admin-panel"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" title="Reviews & Queries" value="about_us" to="contacts-reviews"></v-list-item>
                        <v-list-item prepend-icon="mdi-help" title="Refund Queries" value="Purchased ads" to="/refunded-queries"></v-list-item>

                    </v-list>

                    <v-list density="compact" nav v-else-if="getuserinfo.role === 'User'">
                        <v-list-item prepend-icon="mdi-home" title="Home" value="home" to="home"></v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker" title="Destinations" value="destinations" to="Destination"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" title="About Us" value="about_us" to="about"></v-list-item>
                    </v-list>
                    <v-list density="compact" nav v-else-if="getuserinfo.role === 'Company'">
                        <v-list-item prepend-icon="mdi-home" title="Home" value="home" to="home"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" title="About Us" value="about_us" to="about"></v-list-item>
                        <v-list-item prepend-icon="mdi-plus" title="Post your AD" to="postad" value="shared"></v-list-item>
                    </v-list>

                    <template v-slot:append>
                        <v-list density="compact" nav v-if="getuserinfo.role === 'Admin'">
<!--                            <v-list-item prepend-icon="mdi-help" title="Refund Queries" value="Purchased ads" to="/refunded-queries"></v-list-item>-->
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                        <v-list density="compact" nav v-else-if="getuserinfo.role === 'Company'">
                            <v-list-item prepend-icon="mdi-account" title="My Packages" value="My ads" to="/myads"></v-list-item>
<!--                            <v-list-item prepend-icon="mdi-advertisements" title="Purchased Packages" value="Purchased ads" to="/purchased-ads"></v-list-item>-->
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                        <v-list density="compact" nav v-else-if="getuserinfo.role === 'User'">
<!--                            <v-list-item prepend-icon="mdi-account" title="My Packages" value="My ads" to="/myads"></v-list-item>-->
                            <v-list-item prepend-icon="mdi-advertisements" title="Purchased Packages" value="Purchased ads" to="/purchased-ads"></v-list-item>
                            <v-list-item prepend-icon="mdi-credit-card-refund" title="Refunded Packages" value="Refunded Packages" to="/refunded-packages"></v-list-item>
<!--                            <v-list-item prepend-icon="mdi-credit-card-refund" title="Refunded Packages" value="Refunded Packages" to="/refunded-packages"></v-list-item>-->
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                    </template>
                </v-navigation-drawer>
                <v-main class="hidden-md-and-down" v-if="isHiddenXsAndDown" >
                    <router-view></router-view>
                </v-main>
            </v-layout>
        </v-card>
    </template>
    <template v-if="isAuthenticated && isHiddenMdAndDown">
        <v-card>
            <v-layout>
                <v-navigation-drawer
                    theme="dark"
                    rail
                    permanent
                    location="left"
                    class="hidden-xs-and-down hidden-lg-and-up hidden-xs"
                >
                    <v-list-item
                        nav
                        :prepend-avatar="image || defaultImage"
                        @click="showModal = true"
                    ></v-list-item>

                    <v-divider></v-divider>

                    <v-list density="compact" nav v-if="getuserinfo.role === 'Admin'">
                        <v-list-item prepend-icon="mdi-home" to="admin-panel"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" to="contacts-reviews"></v-list-item>
                        <v-list-item prepend-icon="mdi-help" to="/refunded-queries"></v-list-item>

                    </v-list>

                    <v-list density="compact" nav v-else-if="getuserinfo.role === 'Company'">
                        <v-list-item prepend-icon="mdi-home" to="home"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" to="about"></v-list-item>
                        <v-list-item prepend-icon="mdi-plus" to="postad"></v-list-item>
                    </v-list>
                    <v-list density="compact" nav v-else-if="getuserinfo.role === 'User'">
                        <v-list-item prepend-icon="mdi-home" to="home"></v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker" to="Destination"></v-list-item>
                        <v-list-item prepend-icon="mdi-information" to="about"></v-list-item>
                    </v-list>
                    <template v-slot:append>
                        <v-list density="compact" nav v-if="getuserinfo.role === 'Admin'">
                            <v-list-item prepend-icon="mdi-cog-outline" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" @click="handleLogout"></v-list-item>
                        </v-list>

                        <v-list density="compact" nav v-else-if="getuserinfo.role === 'Company'">
                            <v-list-item prepend-icon="mdi-account" to="/myads"></v-list-item>
                            <v-list-item prepend-icon="mdi-cog-outline" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" @click="handleLogout"></v-list-item>
                        </v-list>
                        <v-list density="compact" nav v-else-if="getuserinfo.role === 'User'">

                            <v-list-item prepend-icon="mdi-advertisements" to="/purchased-ads"></v-list-item>
                            <v-list-item prepend-icon="mdi-credit-card-refund" value="Refunded Packages" to="/refunded-packages"></v-list-item>

                            <v-list-item prepend-icon="mdi-cog-outline" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" @click="handleLogout"></v-list-item>
                        </v-list>
                    </template>
                </v-navigation-drawer>
                <v-main class="hidden-xs-and-down hidden-lg-and-up hidden-xs" v-if="isAuthenticated && isHiddenMdAndDown">
                    <router-view></router-view>
                </v-main>
            </v-layout>
        </v-card>
    </template>
    <template v-if="isAuthenticated && isHiddenLgAndUp">
        <div class="hidden-sm-and-up">
            <v-layout>
                <v-app-bar style="background-color: #212121" prominent>
                    <v-toolbar-title class="font-weight-bold" style="color: #ffffff">
                        TRAVELBOO
                    </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-menu theme="dark" v-if="getuserinfo.role === 'Admin'">
                        <template v-slot:activator="{ props }">
                            <v-btn icon="mdi-dots-vertical" v-bind="props" style="color: #ffffff"></v-btn>
                        </template>

                        <v-list>
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                    </v-menu>

                    <v-menu theme="dark" v-if="getuserinfo.role === 'User'">
                        <template v-slot:activator="{ props }">
                            <v-btn icon="mdi-dots-vertical" v-bind="props" style="color: #ffffff"></v-btn>
                        </template>
                        <v-list>
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-advertisements" title="Purchased Packages" value="Purchased ads" to="/purchased-ads"></v-list-item>
                            <v-list-item prepend-icon="mdi-credit-card-refund" title="Refunded Packages" value="Refunded Packages" to="/refunded-packages"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                    </v-menu>

                    <v-menu theme="dark" v-else-if="getuserinfo.role === 'Company'" >
                        <template v-slot:activator="{ props }">
                            <v-btn icon="mdi-dots-vertical" v-bind="props" style="color: #ffffff"></v-btn>
                        </template>

                        <v-list>
                            <v-list-item prepend-icon="mdi-account" title="My ads" value="My Packages" to="/myads"></v-list-item>
                            <v-list-item prepend-icon="mdi-cog-outline" title="Settings" value="Settings" to="/user-update"></v-list-item>
                            <v-list-item prepend-icon="mdi-logout" title="Logout" value="logout" @click="handleLogout"></v-list-item>
                        </v-list>
                    </v-menu>
                </v-app-bar>

                <v-main v-if="isHiddenLgAndUp">
                    <router-view></router-view>
                </v-main>
            </v-layout>
        </div>
    </template>
    <template v-else-if="!isAuthenticated">
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top "
             :style="{
        marginLeft: '45px',
        marginRight: '45px',
        padding: scrolled ? '10px' : '25px'
     }"
             :class="{'navbar-color': this.$router.path === '/Destination','navbar-scrolled': scrolled}">
            <div class="container">
                <router-link to="Home" class="navbar-brand" style="color: white">TRAVELBOO</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-lg-0">
                        <li class="nav-item">
                            <router-link to="Home" class="link" :class="{ 'link-active': $route.path === '/Home' }">
                                Home
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="Destination" class="link"
                                         :class="{ 'link-active': $route.path === '/Destination' }">Destination
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="About" class="link"
                                         :class="{ 'link-active': $route.path === '/About' }">About
                                Us
                            </router-link>
                        </li>
                    </ul>
                    <div class="position-adjustment">
                        <router-link to="Signup" class="btnn">
                            Get
                            Started
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>
        <router-view></router-view>
    </template>
    <appAvatar :show="showModal" @close="closeModal"/>
    <div class="modal-backdrop fade show" v-if="showModal"></div>
</template>

<script>


import {mapActions, mapGetters} from "vuex";
import AppAvatar from "../Components/pages/appAvatar";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {ref} from 'vue';

// const pusher = new Pusher("97fde42844b93bd5ed80", {
//     cluster: "ap2",
//     encrypted: true,
// });
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '97fde42844b93bd5ed80',
//     cluster: 'ap2',
//     encrypted: true,
// });
// window.Echo.channel('ad-purchased')
//     .listen('AdPurchased', (event) => {
//         // Handle the notification for the ad purchaser
//         console.log('You have purchased the ad with ID:', event.adId);
//
//         // Handle the notification for the ad owner
//         console.log('Your ad with ID', event.adId, 'has been purchased by user with ID', event.userId);
//     });
export default {
    name: "appHeader",
    components: {AppAvatar},
    computed: {
        ...mapGetters(["isAuthenticated", "getuserinfo"]),
        userinfo() {
            return this.getuserinfo;
        },
        firstname() {
            return this.userinfo ? this.userinfo.firstname : null;
        },
        lastname() {
            return this.userinfo ? this.userinfo.lastname : null;
        },
        image() {
            return this.userinfo ? this.userinfo.image : null;
        },
        capitalizeFirstLetter() {
            return (value) => {
                if (!value) return '';
                return value.charAt(0).toUpperCase() + value.slice(1);
            };
        }
    },
    data() {
        return {
            // notifications: [],
            defaultImage: "storage/avatar/default.png",
            scrolled: false,
            showModal: false,
            isHiddenMdAndDown: false,
            isHiddenXsAndDown: false,
            isHiddenLgAndUp: false,
        };
    },

    methods: {
        handleResize() {
            const screenWidth = window.innerWidth;
            this.isHiddenMdAndDown = screenWidth >= 600 && screenWidth <=1279  ; // Adjust the width as needed
            this.isHiddenXsAndDown = screenWidth >= 1280; // Adjust the width as needed
            this.isHiddenLgAndUp = screenWidth <= 599;  // Adjust the width as needed
        },
        // listenForAdPurchasedNotifications() {
        //     const echo = new Echo({
        //         broadcaster: 'pusher',
        //         key: '97fde42844b93bd5ed80',
        //         cluster: 'ap2',
        //         // Add other necessary configuration options based on your setup
        //     });
        //
        //     echo.channel('ad-purchased')
        //         .listen('.AdPurchased', (event) => {
        //             console.log('Event received:', event);
        //             // Handle the ad purchased event
        //         });
        // },
        ...mapActions(["logout"]),
        handleLogout() {
            this.$store
                .dispatch("logout")
                .then(() => {
                    this.$router.push("Home");
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        handleScroll() {
                this.scrolled = window.scrollY >= 56;
        },
        closeModal() {
            this.showModal = false;
        },
    },
    mounted() {
        // this.listenForAdPurchasedNotifications();
        this.$store.dispatch("userinfo");
        window.addEventListener("scroll", this.handleScroll);
        window.Echo.channel('ad-purchased-channel')
            .listen('.AdPurchased', (event) => {
                console.log('Event received:', event);
            });
        // this.$store.dispatch('checkAuth');
    },
    created() {
        this.handleResize();
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
    beforeUnmount() {
        window.removeEventListener("scroll", this.handleScroll);
    },
};
</script>
<style scoped>
@media (min-width: 0px) and (max-width: 992px) {
    .position-adjustment{
        margin-top: 20px;
    }
}
.fixed-top {
    top: 20px;
}
.navbar-brand {
    color: #ffffff;
    font-weight: bold;
    font-family: 'Alkatra', cursive;
}
.navbar-brand:hover {
    color: #ffffff;
}


.navbar{
    background-color: #1c1c1c;
    transition: all 0.5s;
}
</style>
