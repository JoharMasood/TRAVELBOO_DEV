<template>
    <section class="banner">
        <video ref="video" src="/assets/banner.mp4" poster="/assets/banner.mp4" autoplay loop muted></video>
        <div class="content">
            <p class="title_of_banner">
                Find the next place to explore <br>
                <span> the beauty of</span> <span class="waviy">
            <span style="--i:1">P</span>
            <span style="--i:2">a</span>
            <span style="--i:3">k</span>
            <span style="--i:4">i</span>
            <span style="--i:5">s</span>
            <span style="--i:6">t</span>
            <span style="--i:7">a</span>
            <span style="--i:8">n</span>
        </span>
            </p>

            <p class="description_of_banner">
                Find the destination and book anytime, anywhere to explore this.
            </p>
            <div class=" d-flex justify-content-center">
                <router-link to="Destination" class="btnn mr-4">Let's Explore</router-link>
                <div v-if="isPlaying === true">
                    <v-icon color="#f0582b" style="font-size: 40px" @click="togglePlayPause">mdi-motion-play</v-icon>
                    <span class="font-weight-bold ml-1" style="color: #ffffff;font-family: 'Alkatra', cursive; ">Pause Video</span>
                </div>
                <div v-else>
                    <v-icon color="#f0582b" style="font-size: 40px" @click="togglePlayPause">mdi-motion-pause</v-icon>
                    <span class="font-weight-bold ml-1" style="color: #ffffff;font-family: 'Alkatra', cursive;">Play Video</span>
                </div>
            </div>
        </div>
    </section>
    <section class="feature-destination">
        <div class="container">
            <div class="row">
                <div class="col-md-4 element-animate fadeInUp element-animated">
                    <router-link to="/Destination" class="img-bg" style="background-image: url('assets/n1.png')">
                        <div class="text">
                            <v-icon>mdi-location</v-icon>
                            <h2>Skardu, Pakistan</h2>
                            <p>Visit This Place</p>
                        </div>
                    </router-link>
                </div>
                <div class="col-md-4 element-animate fadeInUp element-animated">
                    <router-link to="/Destination" class="img-bg" style="background-image: url('assets/n2.png')">
                        <div class="text">
                            <v-icon>mdi-location</v-icon>
                            <h2>Attabad lake</h2>
                            <p>Visit This Place</p>
                        </div>
                    </router-link>
                </div>
                <div class="col-md-4 element-animate fadeInUp element-animated">
                    <router-link to="/Destination" class="img-bg last" style="background-image: url('assets/n3.png')">
                        <div class="text">
                            <v-icon>mdi-location</v-icon>
                            <h2>Karakoram Highway</h2>
                            <p>Visit This Place</p>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </section>
    <section class="appdata">
        <div class="container">
            <div class="row flex-sm-row-reverse">
                <div class="col-lg-6 col-md-6 col-sm-12 padding_bottom">
                    <div class="appdecriptipn wow  animated animate__slideInRight">
                        <p class="apptitle">
                            Travelboo trips for<br> modern travellers
                        </p>
                        <p class="description_of_section">
                            Our unique itinerary builder gives you the power to design your dream trip. Backed by a
                            passionate team of travel expert and selected by you.
                        </p>
                        <div class="appads">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex">
                                    <v-icon color="#f0582b" class="mr-4">mdi-compass</v-icon>
                                    <p class="context">Browse our trip</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex">
                                    <v-icon color="#f0582b" class="mr-4">mdi-atom</v-icon>
                                    <p class="context">Design your itinerary</p>
                                </div>
                            </div>
                        </div>
                        <div class="appads">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex">
                                    <v-icon class="mr-4" color="#f0582b">mdi-handshake</v-icon>
                                    <p class="context">Connect with an expert</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex">
                                    <v-icon color="#f0582b" class="mr-4">mdi-transit-connection-variant</v-icon>
                                    <p class="context">Travelbetter</p>
                                </div>
                            </div>
                        </div>
                        <div class="appbutton mt-3">
                            <router-link to="#" class="btnn">Explore all trips</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="appimage wow  animated slideInLeft">
                        <img src="assets/l1.png" class="img-fluid image" alt="">
                        <div class="text-block">
                            <p>Exceptional adventures, <br> every time. Start designing <br> your dream trip today. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="review_section" >
        <div class="section_content">
            <p class="title_of_section">
                Loved by over million travelers
            </p>
        </div>
        <div class="handleMessage" v-if="!getRandomReviews || getRandomReviews.length === 0">
            Reviews not exist yet.
        </div>
        <div class="rating_section" v-else>
            <div class="d-flex justify-space-around">
                <div class="card hidden-sm-and-down" style="width: 18rem;top: 20px; filter: blur(4px);">
                    <div class="d-flex flex-column align-items-center">
                        <v-avatar size="55" class="avatar">
                            <img :src="card1.user_image || defaultImage" style="height: 100%; width: 100%;" alt="Avatar">
                        </v-avatar>
                        <div class="name">{{ card1.user_name }}</div>
                        <v-rating v-model="card1.ratings" :half-increments="true" :readonly="true" size="30"
                                  color="orange"></v-rating>
                    </div>
                    <div class="card-body">
                        <div class="name">{{ card1.comment }}</div>
                    </div>
                </div>
                <div class="card hidden-xs" style="width: 18rem; top: 10px; filter: blur(2px);">
                    <div class="d-flex flex-column align-items-center">
                        <v-avatar size="55" class="avatar">
                            <img :src="card2.user_image || defaultImage" style="height: 100%; width: 100%;" alt="Avatar">
                        </v-avatar>
                        <div class="name">{{ card2.user_name }}</div>
                        <v-rating v-model="card2.ratings" :half-increments="true" :readonly="true" size="30"
                                  color="orange"></v-rating>
                    </div>
                    <div class="card-body">
                        <div class="name">{{ card2.comment }}</div>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="d-flex flex-column align-items-center">
                        <v-avatar size="55" class="avatar">
                            <img :src="card3.user_image || defaultImage" style="height: 100%; width: 100%;" alt="Avatar">
                        </v-avatar>
                        <div class="name">{{ card3.user_name }}</div>
                        <v-rating v-model="card3.ratings" :half-increments="true" :readonly="true" size="30"
                                  color="orange"></v-rating>
                    </div>
                    <div class="card-body">
                        <div class="name">{{ card3.comment }}</div>
                    </div>
                </div>
                <div class="card hidden-xs" style="width: 18rem;top: 10px; filter: blur(2px);">
                    <div class="d-flex flex-column align-items-center">
                        <v-avatar size="55" class="avatar">
                            <img :src="card4.user_image || defaultImage" style="height: 100%; width: 100%;" alt="Avatar">
                        </v-avatar>
                        <div class="name">{{ card4.user_name }}</div>
                        <v-rating v-model="card4.ratings" :half-increments="true" :readonly="true" size="30"
                                  color="orange"></v-rating>
                    </div>
                    <div class="card-body">
                        <div class="name">{{ card4.comment }}</div>
                    </div>
                </div>
                <div class="card hidden-sm-and-down" style="width: 18rem;top: 20px; filter: blur(4px);">
                    <div class="d-flex flex-column align-items-center">
                        <v-avatar size="55" class="avatar">
                            <img :src="card5.user_image || defaultImage" style="height: 100%; width: 100%;" alt="Avatar">
                        </v-avatar>
                        <div class="name">{{ card5.user_name }}</div>
                        <v-rating v-model="card5.ratings" :half-increments="true" :readonly="true" size="30"
                                  color="orange"></v-rating>
                    </div>
                    <div class="card-body">
                        <div class="name">{{ card5.comment }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="app_section">
        <div class="section_content">
            <p class="title_of_section wow animate__animated animate__zoomIn">
                How we can help your journey
            </p>
            <p class="description_of_title">
                Our services which are very comfortable and make you happy.
            </p>
        </div>
        <div class="row no-gutters custom-row">
            <div
                class="col-md-6 col-lg-3 d-flex services align-self-stretch py-5 px-4 bg-primary wow animate__animated animate__slideInUp slower-animation1">
                <div class="media block-6 d-block text-center">
                    <div class="media-body p-2 mt-3">
                        <v-icon color="#ff0000" class="mb-4" size="40px">mdi-earth</v-icon>
                        <h3 class="heading">Find your destination</h3>
                        <p class="heading">Find your travel destination, we have covered the whole Pakistan on our
                            website.</p>
                    </div>
                </div>
            </div>
            <div
                class="col-md-6 col-lg-3 d-flex services align-self-stretch py-5 px-4 bg-darken wow animate__animated animate__slideInUp slower-animation2">
                <div class="media block-6 d-block text-center">
                    <div class="media-body p-2 mt-3">
                        <v-icon color="#ff0000" class="mb-4" size="40px">mdi-ticket-outline</v-icon>
                        <h3 class="heading">Book a ticket</h3>
                        <p class="heading">After finding the trip you want to go to, you can immediately order the
                            ticket.</p>
                    </div>
                </div>
            </div>
            <div
                class="col-md-6 col-lg-3 d-flex services align-self-stretch py-5 px-4 bg-primary wow animate__animated animate__slideInUp slower-animation3">
                <div class="media block-6 d-block text-center">
                    <div class="media-body p-2 mt-3">
                        <v-icon color="#ff0000" class="mb-4" size="40px">mdi-currency-usd</v-icon>
                        <h3 class="heading">Pay and explore destination</h3>
                        <p class="heading">After you pay, you can immediately enjoy the trip to your desired
                            destination.</p>
                    </div>
                </div>
            </div>
            <div
                class="col-md-6 col-lg-3 d-flex services align-self-stretch py-5 px-4 bg-darken wow animate__animated animate__slideInUp slower-animation4">
                <div class="media block-6 d-block text-center">
                    <div class="media-body p-2 mt-3">
                        <v-icon color="#ff0000" class="mb-4" size="40px">mdi-message-draw</v-icon>
                        <h3 class="heading">Submit Reviews</h3>
                        <p class="heading">Don't forget to share your experience by giving ratings to different
                            companies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="app_section">
        <div class="section_content">
            <v-carousel
                cycle
                height="600"
                hide-delimiter-background
                show-arrows="hover"
            >
                <v-carousel-item src="/assets/p1.png" cover>
                    <div class="carousel-item-content">
                        <div class="home_text_large">discover</div>
                        <div class="home_text_small">Discover new worlds</div>
                    </div>
                </v-carousel-item>

                <v-carousel-item src="/assets/p2.png" cover>
                    <div class="carousel-item-content">
                        <div class="home_text_large">discover</div>
                        <div class="home_text_small">Discover new worlds</div>
                    </div>
                </v-carousel-item>

                <v-carousel-item src="/assets/p3.png" cover>
                    <div class="carousel-item-content">
                        <div class="home_text_large">discover</div>
                        <div class="home_text_small">Discover new worlds</div>
                    </div>
                </v-carousel-item>
            </v-carousel>
        </div>
    </section>
    <section class="section-cover" data-stellar-background-ratio="0.5"
             style="background-image: url('assets/n4.png'); background-attachment: fixed;">
        <div class="container">
            <div class="row justify-content-center align-items-center intro">
                <div class="col-md-7 text-center wow animate__animated fadeInUp">
                    <h2>Get 10% off On Your Next Travel</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto quidem tempore expedita
                        facere facilis, dolores!</p>
                    <p v-if="isAuthenticated">
                        <router-link to="Destination" class="btn btn-black">Destination</router-link>
                    </p>
                    <p v-else>
                        <router-link to="Signup" class="btn btn-black">Get Started</router-link>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-section" data-stellar-background-ratio="0.5" style="background-image: url('assets/n4.png');
        background-attachment: fixed;
        background-size: cover;
        padding: 100px 0;">
        <div class="contact-container">
            <div class="contact-form">
                <h2 style="color: #fff;">Contact Us</h2>
                <form @submit.prevent="handlesubmit">
                    <input type="text" name="name" placeholder="Your Name" required v-model="name">
                    <input type="email" name="email" placeholder="Your Email" required v-model="email">
                    <input type="tel" name="phone" placeholder="Your Phone Number" required v-model="number">
                    <textarea name="message" placeholder="Your Message" required v-model="message"></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {

    name: "Home",
    components: {},

    data() {
        return {
            defaultImage: "storage/avatar/default.png",
            email: '',
            message: '',
            number: '',
            name: '',
            isPlaying: true,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated', 'getsubmitcontactresponse', 'getRandomReviews']),
        card1() {
            return this.getRandomReviews[0] || {};
        },
        card2() {
            return this.getRandomReviews[1] || {};
        },
        card3() {
            return this.getRandomReviews[2] || {};
        },
        card4() {
            return this.getRandomReviews[3] || {};
        },
        card5() {
            return this.getRandomReviews[4] || {};
        }
    },
    mounted() {
        setInterval(this.progress, 2000);
        this.$store.dispatch('fetchRandomReviews');
    },
    methods: {
        ...mapActions(['postcontactDetails']),
        async handlesubmit() {

            try {
                await this.postcontactDetails({
                    name: this.name,
                    email: this.email,
                    phonenumber: this.number,
                    message: this.message
                })
            } catch (e) {
                console.log(e)
            }
        },
        togglePlayPause() {
            if (this.isPlaying) {
                this.$refs.video.pause();
            } else {
                this.$refs.video.play();
            }
            this.isPlaying = !this.isPlaying;
        }
    }
}
</script>

<style scoped>

@media (min-width: 0px) and (max-width: 767px) {
    .padding_bottom{
        padding-bottom: 30px;
    }
}
.custom-row {
    --bs-gutter-x: 0;
    margin-right: calc(var(--bs-gutter-x) * -1);
    margin-left: calc(var(--bs-gutter-x) * -1);
}
.pointer-list li {
    /*list-style-type: none;*/
}
.handleMessage{
    font-size: 4vw;
    text-align: center;
    background-color: gainsboro;
    padding: 50px 0px;
    margin-bottom: 35px;
    font-family: 'Alkatra', cursive;
    /* font-weight: bolder; */
    color: #000;
}
.home_text_small {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    width: 100%;
    font-size: 72px;
    font-weight: 400;
    color: #FFFFFF;
    text-shadow: 0px 11px 51px rgba(0,0,0,0.35);
    font-family: 'Alkatra', cursive;
}
.home_text_large {
    font-size: 215px;
    font-weight: 900;
    color: #fdaa27;
    opacity: 0.34;
    text-transform: uppercase;
    line-height: 0.75;
}
.carousel-item-content{
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    justify-content: center;
    position: absolute;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 80%;
    text-align: center;
}
@media (min-width: 0px) and (max-width: 766px) {
    .apptitle{
        text-align: center;
    }
}
.image{
    border-radius: 20px;
}
.card {
    padding: 30px;
    border: none;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
}

.card:hover {
    background-color: #f0582b;
    /*background-color: #000;*/
    color: #ffffff;
    transition: background-color 0.5s ease;
}

.contact-container {
    width: 90%;
    max-width: 600px;
    margin: 0 auto;
    padding: 40px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.04);
    box-shadow: -9px 1px 28px 0px rgb(0 0 0 / 29%);
}

.contact-form {
    width: 100%;
}

.contact-form h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

.contact-form input[type="text"],
.contact-form input[type="email"],
.contact-form input[type="tel"],
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: none;
    border-radius: 5px;
    background-color: #f2f2f2;
    font-size: 16px;
    color: #555;
}

.contact-form textarea {
    height: 100px;
    resize: none;
}

.contact-form button[type="submit"] {
    width: 100%;
    border: none;
    background: #000;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    /*font-size: 18px;*/
    transition: .3s all ease;
    padding: 12px 30px;
}

.contact-form button[type="submit"]:hover {
    background: #000;
    color: #fff;
}

@media (max-width: 768px) {
    .contact-container {
        padding: 20px;
    }
}


.section-cover {
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
}

.btn {
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
    padding: 12px 30px;
}

.btn:hover {
    background: #000;
    color: #fff;
}

.btn:visited {
    background: #000;
    color: #fff;
}

.btn:focus {
    background: #000;
    color: #fff;
}

.btn.btn-black {
    background: #000;
    color: #fff;
}

.section-cover p {
    color: #fff;
}

.section-cover h2 {
    color: #fff;
}

.section-cover .intro {
    height: 500px;
}

.feature-destination, .slider-wrap {
    position: relative;
    z-index: 1 !important;
    margin-top: -50px;
    margin-bottom: 50px;
}

.feature-destination .img-bg, .slider-wrap .img-bg {
    margin-bottom: 30px;
    display: block;
    height: 300px;
    position: relative;
    top: 0;
    -webkit-transition: .2s all ease;
    -o-transition: .2s all ease;
    transition: .2s all ease;
    background-size: cover;
    background-position: center;
}

.feature-destination .img-bg:before, .slider-wrap .img-bg:before {
    content: "";
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: #000;
    opacity: .1;
    position: absolute;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
}

.feature-destination .img-bg .text, .slider-wrap .img-bg .text {
    position: absolute;
    top: 50%;
    left: 50%;
    text-align: center;
    width: 80%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.feature-destination .img-bg .text .icon, .slider-wrap .img-bg .text .icon {
    color: #fff;
    font-size: 30px;
    position: relative;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
    top: 0;
}

.feature-destination .img-bg .text h2, .slider-wrap .img-bg .text h2 {
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
    margin: 0;
    padding: 0;
    font-size: 18px;
    font-weight: 400;
    color: #fff;
    top: 0px;
    position: relative;
}

.feature-destination .img-bg .text p, .slider-wrap .img-bg .text p {
    color: #fff;
    opacity: 0;
    top: 10px;
    visibility: hidden;
    font-size: 13px;
    position: relative;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
}

.feature-destination .img-bg:hover, .feature-destination .img-bg:focus, .slider-wrap .img-bg:hover, .slider-wrap .img-bg:focus {
    top: -10px;
    -webkit-box-shadow: 2px 0 20px 0 rgba(0, 0, 0, 0.4);
    box-shadow: 2px 0 20px 0 rgba(0, 0, 0, 0.4);
}

.feature-destination .img-bg:hover .text .icon, .feature-destination .img-bg:focus .text .icon, .slider-wrap .img-bg:hover .text .icon, .slider-wrap .img-bg:focus .text .icon {
    top: -10px;
}

.feature-destination .img-bg:hover .text h2, .feature-destination .img-bg:focus .text h2, .slider-wrap .img-bg:hover .text h2, .slider-wrap .img-bg:focus .text h2 {
    top: -10px;
}

.feature-destination .img-bg:hover .text p, .feature-destination .img-bg:focus .text p, .slider-wrap .img-bg:hover .text p, .slider-wrap .img-bg:focus .text p {
    top: 0;
    opacity: .5;
    visibility: visible;
}

.feature-destination .img-bg:hover:before, .feature-destination .img-bg:focus:before, .slider-wrap .img-bg:hover:before, .slider-wrap .img-bg:focus:before {
    opacity: .4;
}

.slower-animation1 {
    animation-duration: 0.3s; /* Increase the duration to slow down the animation */

}

.slower-animation2 {
    animation-duration: 0.6s; /* Increase the duration to slow down the animation */
}

.slower-animation3 {
    animation-duration: 0.9s; /* Increase the duration to slow down the animation */
}

.slower-animation4 {
    animation-duration: 1.2s; /* Increase the duration to slow down the animation */
}

.heading {
    color: #adb5bd;
}

.bg-primary {
    background: #1c1c1c !important ;
}

.bg-darken {
    background: #1c1c1c !important ;
}

.appimage {
    width: 100%;
    height: auto;
    border-radius: 20px;
    position: relative;
}

.text-block {
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
    position: absolute;
    bottom: -25px;
    right: -12px;
    background-color: #fff;
    color: #000;
    padding-left: 20px;
    padding-right: 20px;
    border-radius: 10px;
    padding-top: 10px;
}

.description_of_section {
    color: #a39e92;
    width: auto;
    height: auto;
    text-align: left;
    display: flex;
    justify-content: center;
}

.apptitle {
    color: #f0582b;
    width: auto;
    height: auto;
    font-weight: bold;
    font-family: 'Alkatra', cursive;
}

@media (max-width: 992px) {
    .context {
        font-size: 13px;
    }
}

@media (max-width: 768px) {
    .apptitle {
        font-size: calc(29px + 0.390625vw)
    }
}

@media (min-width: 768px) {
    .apptitle {
        font-size: calc(20px + 0.390625vw)
    }
}

.description_of_section {
    font-size: 17px;
}

@media (max-width: 992px) {
    .description_of_section {
        font-size: 13px
    }
}

@media (min-width: 992px) {
    .apptitle {
        font-size: calc(35px + 0.390625vw)
    }
}

@media (min-width: 1200px) {
    .appads {

        margin-bottom: 20px;
    }
}

@media (min-width: 1280px) {
    .apptitle {
        font-size: calc(45px + 0.390625vw)
    }
}

.appdecriptipn {
    margin-left: 64px
}

@media (max-width: 767px) {
    .appdecriptipn {
        margin-left: 0px;
    }
}


.appdata {
    /*padding-top: 130px;*/
    padding-bottom: 100px;
}

.appads {
    color: #a39e92;
}


.discount_banner {
    background-color: #312d1a;
    padding-top: 80px;
    padding-bottom: 120px;
}

.discount_title {
    color: #fff;
    font-size: 64px;
}

@media (max-width: 768px) {
    .discount_title {
        font-size: calc(30px + 0.390625vw)
    }
}

@media (min-width: 768px) {
    .discount_title {
        font-size: calc(30px + 0.390625vw)
    }
}

@media (min-width: 1024px) {
    .discount_title {
        font-size: calc(35px + 0.390625vw)
    }
}

@media (min-width: 1280px) {
    .discount_title {
        font-size: calc(45px + 0.390625vw)
    }
}

.discount_description {
    color: #77725d;
}

@media (max-width: 767px) {
    .discount_description {
        margin-top: 50px;
    }
}

@media (max-width: 767px) {
    .discount_banner {
        padding-bottom: 60px;
    }
}

.rating_section {
    padding-bottom: 100px;
}



.title_of_banner {
    color: #ffffff;
    font-family: 'Alkatra', cursive;
}

@media (max-width: 768px) {
    .title_of_banner {
        font-size: calc(27px + 0.390625vw)
    }
}

@media (min-width: 768px) {
    .title_of_banner {
        font-size: calc(35px + 0.390625vw)
    }
}

@media (min-width: 1024px) {
    .title_of_banner {
        font-size: calc(45px + 0.390625vw)
    }
}

@media (min-width: 1280px) {
    .title_of_banner {
        font-size: calc(60px + 0.390625vw)
    }
}

.description_of_banner {
    color: #ffffff;
    font-family: 'Alkatra', cursive;
}

@media (max-width: 1024px) {
    .description_of_banner {
        font-size: 10px
    }
}

.title_of_section {
    font-family: 'Alkatra', cursive;
    font-weight: bolder;
    color: #f0582b;
    width: auto;
    height: auto;
    text-align: center;
}

@media (max-width: 768px) {
    .title_of_section {
        font-size: calc(30px + 0.390625vw)
    }
}

@media (min-width: 768px) {
    .title_of_section {
        font-size: calc(30px + 0.390625vw)
    }
}

@media (min-width: 1024px) {
    .title_of_section {
        font-size: calc(35px + 0.390625vw)
    }
}

@media (min-width: 1280px) {
    .title_of_section {
        font-size: calc(45px + 0.390625vw)
    }
}

.description_of_title {
    font-family: 'Alkatra', cursive;
    width: auto;
    height: auto;
    text-align: center;
    font-size: 80%;
    color: #a39e92;
}

@media (max-width: 768px) {
    .waviy span {
        font-size: calc(27px + 0.390625vw)
    }
}

@media (min-width: 768px) {
    .waviy span {
        font-size: calc(35px + 0.390625vw)
    }
}

@media (min-width: 1024px) {
    .waviy span {
        font-size: calc(45px + 0.390625vw)
    }
}

@media (min-width: 1280px) {
    .waviy span {
        font-size: calc(60px + 0.390625vw)
    }
}

@media (max-width: 992px) {
    .extra_content {
        display: none;
    }
}

@media (max-width: 992px) {
    .addclass {
        display: none;
    }
}

.extra_content {
    width: 30%;
}

.altclass {
    bottom: -145px;
    position: relative;
    border-radius: 7px;
    margin-right: 30px;
}

.alt {
    bottom: -145px;
    position: relative;
    border-radius: 10px;
}

.waviy {
    position: relative;
}

.waviy span {
    position: relative;
    display: inline-block;
    color: #fff;
    text-transform: uppercase;
    animation: flip 2s infinite;
    animation-delay: calc(.2s * var(--i))
}

@keyframes flip {
    0%, 80% {
        transform: rotateY(360deg)
    }
}

.banner {
    position: relative;
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 1;
    display: grid;
    place-items: center;
}

.banner video {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.content {
    position: absolute;
    width: auto;
    height: auto;
    text-align: center;
}

.btnn {
    border-radius: 20px;
    padding: 8px 19px 8px 19px;
    background-color: #e56137;
    color: #fff;
    text-decoration: none;
}

.btnn:focus {
    background-color: #f0582b;
    color: #ffffff;
}

.btnn:hover {
    background-color: #f0582b;
    color: #ffffff;
}

.btnn:active {
    background-color: #f0582b;
    color: #ffffff;
}
</style>
