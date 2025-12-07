<template>
    <div class="height">
        <div v-if="!refundedads || refundedads.length === 0" class="message">
            <h2 style="font-size: 3vw;">No Refund history found.</h2>
        </div>
        <div v-for="ownername in refundedads" v-else>
            <div class="container-fluid background mb-5">
                <div class="container">
                    <div class="nav justify-content-between">
                        <div class="d-flex align-center" :key="ownername.ad_owner">
                            <span class="adsowner">Ads posted by: {{ownername.ad_owner}}</span>
                        </div>
                        <div>
                            <span class="adsowner">
                                Refunded Ads
                            </span>
<!--                            <button @click="handlemodal(ownername)" class="btn btn-primary" aria-current="page" >Write a review</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 pb-4 ">
                    <div class="col" v-for="trip in ownername.ads" :key="trip.id">
                        <div class="card h-100">
                            <div class="overlay">
<!--                                <button @click="purchaseDetail(trip)" class="btnn btn btn-black">Show Receipt</button>-->
                            </div>
                            <div class="example">
                                <img :src="trip.image" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Trip to {{trip.place}}</p>
                                    <h5 class="card-title">Rs. {{trip.price}}</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Days: {{trip.days}}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Night: {{trip.night}}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Person: {{trip.person}}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Place: {{formattedValidationDate(trip.validationdate)}}</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated: {{
                                            formattedCreatedAt(trip.updated_at)
                                        }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import {mapGetters} from "vuex";
import moment from "moment/moment";

export default {
    name: 'RefundedPackage',
    data(){
        return {

        }
    },
    computed: {
        formattedValidationDate() {
            return validationdate => {
                const date = new Date(validationdate);
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            };
        },
        ...mapGetters(['getrefundedads']),
        refundedads() {
            return this.getrefundedads.refundedAds;
        },
        userinfo() {
            return this.getrefundedads.detail;
        },
    },
    methods: {
        formattedCreatedAt(timestamp) {
            const currentTime = moment();
            const updatedAt = moment(timestamp);
            const timeDiffInMinutes = currentTime.diff(updatedAt, 'minutes');

            if (timeDiffInMinutes < 1) {
                return 'Just now';
            } else if (timeDiffInMinutes === 1) {
                return '1 minute ago';
            } else if (timeDiffInMinutes < 60) {
                return `${timeDiffInMinutes} minutes ago`;
            } else if (timeDiffInMinutes < 1440) {
                const hours = Math.floor(timeDiffInMinutes / 60);
                return `${hours} ${hours === 1 ? 'hour' : 'hours'} ago`;
            } else {
                return updatedAt.format('MMM DD, YYYY [at] HH:mm'); // Format the timestamp as desired
            }
        },
    },
    mounted() {
        this.$store.dispatch('fetchuserrefundedads');
    }
};
</script>

<style scoped>
.message{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}
.height{
    min-height:100vh;
}
.adsowner{
    color: #ffffff;
    font-weight: bold;
}
.background{
    padding: 20px 0px;
    background-color: #212121;
}
.btnn {
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
    padding: 12px 30px;
    margin-bottom: 20px;
}

.btnn:hover {
    background: #000;
    color: #fff;
}

.btnn:visited {
    background: #000;
    color: #fff;
}

.btnn:active {
    background: #000;
    color: #fff;
}

.btnn.btn-black {
    background: #000;
    color: #fff;
}

.overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    border-radius: 0.375rem;
    transition: .3s all;
    display: flex;
    justify-content: center;
    backdrop-filter: blur(15px);
    align-items: center;
    flex-direction: column;
}

.overlay:hover {
    opacity: 1;
}
</style>
