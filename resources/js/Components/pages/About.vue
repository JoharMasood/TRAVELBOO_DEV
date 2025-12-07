<template>

    <div class="imagecontainer" ref="imageContainer">
        <div class="content">
            <h1 class="heading">About Us</h1>
            <p class="description_of_about">
                Travelboo is a leading online travel platform dedicated to helping users find and book the perfect tour
                packages for their travel adventures. With a vast collection of tour packages from various reputable
                tourism companies, Travelboo offers a diverse range of destinations and experiences to cater to
                different preferences. </p>
        </div>
    </div>
    <section class="app_section pt-12 pb-12">
        <div class="section_detail ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-md-6">
                        <div class="detail_about">
                            <v-icon color="#f0582b" class="mb-6" size="70px">mdi-map-marker-circle</v-icon>
                            <h5 class="mb-3 font-weight-bold text-center">Explore Endless Possibilities</h5>
                            <p class="text text-center mb-6">We offers an extensive collection of tour packages from
                                various tourism companies, providing a wide range of destinations and experiences to
                                choose from.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6">
                        <div class="detail_about">
                            <v-icon color="#f0582b" class="mb-6" size="70px">mdi-earth</v-icon>
                            <h5 class="mb-3 font-weight-bold text-center">Unforgettable Experiences</h5>
                            <p class="text text-center mb-6">Expert guides provide insider knowledge and connect you
                                with local culture, creating immersive experiences. Discover unforgettable moments that
                                will stay with you long after your journey ends.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6">
                        <div class="detail_about">
                            <v-icon color="#f0582b" class="mb-6" size="70px">mdi-compass</v-icon>
                            <h5 class="mb-3 font-weight-bold text-center">Discover the World with Confidence</h5>
                            <p class="text text-center mb-6">We empowers travelers to explore the world with confidence
                                and peace of mind. We partners with trusted tourism companies to curate a selection of
                                secure and well-managed tour packages.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6">
                        <div class="detail_about">
                            <v-icon color="#f0582b" class="mb-6" size="70px">mdi-hours-24</v-icon>
                            <h5 class="mb-3 font-weight-bold text-center">Personalized Support</h5>
                            <p class="text text-center mb-6 ">We believe in providing personalized support and
                                exceptional customer service throughout your travel journey. Our dedicated team is
                                committed to assisting you at every step.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="image-section">
        <div class="row g-0">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="image-content1">
                    <h1 class="content-heading1">history</h1>
                    <h1 class="content-heading">You Explore World</h1>
                    <p class="heading-description handlequery">
                        Exploring means learning. Bring new experiences from each journey. Meet different cultures,
                        traditions and landscapes. Choose your next destination and start your trip.</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="image-content2">asdasdasdd</div>
            </div>
        </div>
    </section>
    <section class="pt-12 pb-12 ">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <img src="/assets/m4.png" alt="" class="img-fluid">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 pr-10 working-margin">
                    <h1 class="company">Largest & Reliable Tourism Company in Pakistan</h1>
                    <p class="description_of_company">TRAVELBOO is the Largest and most reliable tourism company in
                        Pakistan with lots of satisfied clients and we have arranged almost over 200 tours successfully.
                        We offer tour to Hunza Valley, Naltar Valley, Swat, Naran / Kaghan, Khunjrab Pass, Fairy
                        Meadows, and many more incredible places around Pakistan.</p>
                </div>
            </div>
        </div>
    </section>
</template>


<script>
    export default {
        name: 'About',
        mounted() {

        },
        beforeUnmount() {

        },
        methods: {

        },
    };
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Alkatra&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap');

    .company {
        font-size: 40px;

    }
    @media (max-width: 1472px) {
        .heading {
            font-size: 70px !important;
        }
    }
    @media (max-width: 1472px) {
        .description_of_about {
            font-size: 20px !important;
        }
    }
    @media (max-width: 1236px) {
        .description_of_about {
            font-size: 16px !important;
        }
    }
    /*@media (max-width: 1003px) {*/
    /*    .description_of_about {*/
    /*        font-size: 15px !important;*/
    /*    }*/
    /*}*/

    .description_of_company {
        color: #818181;
        font-size: 19px;
        line-height: 30px;
        margin-top: 25px;
    }

    .heading-description {
        color: #ffffff;
        text-align: center;
    }

    .content-heading {
        font-family: 'Fjalla One', sans-serif;
        color: #ffffff;
        font-size: 40px;

    }

    @media (max-width: 990px) {
        .working-margin {
            margin-top: 40px !important;
        }
    }

    .content-heading1 {
        font-family: 'Alkatra', cursive;
        color: #ffcb00;
        font-size: 40px;
    }

    .image-content2 {
        background-image: url('/assets/m3.png');
        background-size: cover;
        background-position: center;
        height: 500px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .image-content1 {
        background-image: url('/assets/m2.png');
        background-size: cover;
        background-position: center;
        height: 500px;
        padding: 138px 23%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .description_of_about {
        padding: 0 20%;
        font-size: 24px;
    }

    .heading {
        font-size: 80px;
        font-weight: bolder;
        margin-bottom: 40px;
    }

    .text {
        color: #808285;
    }

    .imagecontainer {
        background-image: url('/assets/m1.png');
        background-size: cover;
        background-position: center;
        height: 100vh;
        background-attachment: fixed;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 20px;
        color: #fff;
        text-align: center;
    }

    h1 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        line-height: 1.5;
    }

    .app_section {
        background-color: #f5f4ed;
    }

    .detail_about {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>

