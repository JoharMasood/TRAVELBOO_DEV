<template>

    <div class="fullpage">
        <div>
            <div class="container balance">

                <div class="row height d-flex justify-content-center align-items-center">

                    <div class="col-md-8">

                        <div class="search">
                            <input type="text" class="form-control" placeholder="Looking for your Ad? Search now" v-model="searchTerm" @input="handleSearch">
                            <i class="mdi mdi-magnify icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!ads || ads.length === 0" class="message">
                <h2 style="font-size: 3vw;">No result found.</h2>
            </div>
            <div class="container" v-else>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 pb-4 ">
                    <div class="col" v-for="trip in ads" :key="trip.id">
                        <div class="card h-100">
                            <div class="overlay">
                                <button @click="purchaseDetail(trip)" class="btn btn-black">Purchased By</button>
                                <div>
                                    <v-icon @click="deleteAd(trip.id)" class="styling1">mdi-delete</v-icon>
                                    <v-icon @click="update(trip)" class="styling2">mdi-update</v-icon>
                                </div>
                            </div>
                            <div class="example">
                                <img :src="trip.image" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Trip to {{ trip.place }}</p>
                                    <h5 class="card-title">Rs. {{ trip.price }}</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Days: {{ trip.days }}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Night: {{ trip.night }}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Person: {{ trip.person }}</b>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                                <b>Date: {{ formattedValidationDate(trip.validationdate) }}</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated: {{ formattedCreatedAt(trip.updated_at) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <UpdateAdModal @close="closeModel" v-if="showModal" :show="showModal" :trip="trip"></UpdateAdModal>
    <div class="modal-backdrop fade show " v-if="showModal"></div>
    <purchased-ads-modal @close="closeModel1" v-if="showModal1" :show="showModal1" :trip="trip"></purchased-ads-modal>
    <div class="modal-backdrop fade show " v-if="showModal1"></div>
    <AdDeleteConfirmationModal @close="closeModel2" v-if="showModal2" :show="showModal2" :id="id"></AdDeleteConfirmationModal>
    <div class="modal-backdrop fade show " v-if="showModal2"></div>
</template>

<script>
import {mapActions, mapGetters, mapState} from "vuex";
import UpdateAdModal from "./UpdateAdModal";
import PurchasedAdsModal from "./PurchasedAdsModal";
import moment from "moment";
import AdDeleteConfirmationModal from "./AdDeleteConfirmationModal";

export default {
    name: "UserAdsDetails",
    components: {UpdateAdModal, PurchasedAdsModal,AdDeleteConfirmationModal},
    data() {
        return {
            searchTerm: '',
            hover: false,
            showModal: false,
            showModal1: false,
            showModal2: false,
            trip: {},
            id: {},
        }
    },
    computed: {
        ads() {
            return this.$store.getters.getAuthdata;
        },
        handleSearch() {
            this.$store.dispatch('authdata', this.searchTerm);
        },
        formattedValidationDate() {
            return validationdate => {
                const date = new Date(validationdate);
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            };
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
        deleteAd(id) {
            this.id = id
            this.showModal2 = true;

        },
        closeModel() {
            this.showModal = !this.showModal;
        },
        closeModel1() {
            this.showModal1 = !this.showModal1;
        },
        closeModel2() {
            this.showModal2 = !this.showModal2;
        },
        ...mapActions(['processadpurchase']),
        purchaseDetail(trip) {
            this.processadpurchase({
                ad_id: trip.id,
            });
            this.showModal1 = true
        },
        update(trip) {
            this.trip = trip;
            this.showModal = true;
        }
    },

    mounted() {
        this.$store.dispatch('authdata');
        window.addEventListener('hover', this.mouseover);
    },
    destroyed() {
        window.removeEventListener('hover', this.mouseover);
    },
}
</script>

<style scoped>
.icon{
    position: absolute;
    top: 8px;
    left: 10px;
    font-size: 30px;
}
.styling1 {
    border-radius: 3px;
    font-size: 40px;
    margin-right: 15px;
}

.styling1:hover {
    background-color: #f00;
    padding: 0px 50px;
    transition: .3s all ease;
}

.styling1:focus {
    background-color: #f00;
    transition: .3s all ease;
    padding: 0px 50px;
}

.styling2 {
    border-radius: 3px;
    font-size: 40px;
    margin-left: 15px;
}

.styling2:hover {
    background-color: #00FF00;
    transition: .3s all ease;
    padding: 0px 50px;
}

.styling2:focus {
    background-color: #00FF00;
    transition: .3s all ease;
    padding: 0px 50px;
}

.btn {
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
    padding: 12px 30px;
    margin-bottom: 20px;
}

.btn:hover {
    background: #000;
    color: #fff;
}

.btn:visited {
    background: #000;
    color: #fff;
}

.btn:active {
    background: #000;
    color: #fff;
}

.btn.btn-black {
    background: #000;
    color: #fff;
}

.fullpage {
    min-height: 100vh;

}
.message{
    display: flex;
    align-items: center;
    justify-content: center;
}
.balance {
    margin-top: 80px;
    margin-bottom: 70px;
}

.search {
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);
}

.search input {
    height: 60px;
    text-indent: 25px;
    border: 2px solid #d6d4d4;
}

.search input:focus {
    box-shadow: none;
    border: 2px solid blue;
}

.search .fa-search {
    position: absolute;
    top: 20px;
    left: 16px;
}

.search button {
    position: absolute;
    top: 5px;
    right: 5px;
    height: 50px;
    width: 110px;
    background: blue;
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
