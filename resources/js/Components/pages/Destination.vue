<template>
    <div style="min-height: 100vh">
        <div class="background-container">
            <h1 class="heading">Choose Your Destination</h1>
        </div>
        <div class="find">
            <div class="container">
                <div class="find_title text-center">Find the Adventure of a lifetime</div>
                <div class="find_form_container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12 col-md-6 ">
                            <div style="color: #fff" class="margin-top-col">Destination:</div>
                            <input type="text" class="destination find_input "
                                   placeholder="Want to search something?" v-model="query"
                                   @input="debouncedFetchAds">
                        </div>
                        <div class=" col-lg-3 col-sm-12 col-md-6">
                            <div style="color: #fff" class="margin-top-col">Sort Order:</div>
                            <select @change="debouncedFetchAds"
                                    v-model="selectedOption" class="dropdown_item_select  find_input">
                                <option v-for="option in dropdownOptions" :value="option">{{ option }}</option>
                            </select>
                        </div>
                        <div class=" col-lg-3 col-sm-12 col-md-6 margin-top">
                            <div style="color: #fff" class="margin-top-col">Min price</div>
                            <input
                                v-model="range[0]"
                                type="number"
                                class="find_input white-input"
                                style="width: 100%;background-color: rgb(255 255 255 / 0%);"
                                @input="debouncedFetchAds"
                            >
                        </div>
                        <div class="col-lg-3 col-sm-12 col-md-6 margin-top">
                            <div style="color: #fff" class="margin-top-col">Max price</div>
                            <input
                                v-model="range[1]"
                                type="number"
                                class="find_input white-input"
                                style="width: 100%;background-color: rgb(255 255 255 / 0%);"
                                @input="debouncedFetchAds"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="ads && ads.length === 0" style="background-color: lightgray; display: flex; justify-content: center; align-items: center; padding: 60px;">
            <h2 style="font-size: 65px">No ads found.</h2>
        </div>
        <div v-else>
            <div v-for="ownername in ads">
                <div class="container-fluid background mb-5">
                    <div class="container">
                        <div class="nav justify-content-between">
                            <div class="d-flex align-center" :key="ownername.user_name">
                                <span class="adsowner">Ads posted by: {{ ownername.user_name }}</span>
                            </div>
                            <div>
                                <button @click="handlemodal(ownername)" class="btn btn-primary" aria-current="page">
                                    Check
                                    reviews
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 pb-4 ">
                        <div class="col" v-for="trip in ownername.ads" :key="trip.id">
                            <div class="card h-100" @click="showModal=true;update(trip)">
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
    <app-modal
        @close="closeModel"
        :show="showModal"
        :data="data"
    ></app-modal>
    <div class="modal-backdrop fade show " v-if="showModal"></div>
    <ShowReviewModal
        @close="closeModel1"
        :show="showModal1"
        :info="info"
        @update:info="updateInfo"
    ></ShowReviewModal>
    <div class="modal-backdrop fade show " v-if="showModal1"></div>
    </div>

</template>

<script>
import {debounce} from 'lodash';
import AppModal from "./appModal";
import ShowReviewModal from "./ShowReviewModal";
import {onBeforeUnmount, ref} from "vue";
import {mapActions} from 'vuex';
import {useStore} from 'vuex';
import moment from 'moment';

function formatDate(date) {
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = String(date.getFullYear()).slice(-2);
    return `${day}-${month}-${year}`;
}

export default {
    name: "Destination",
    components: {ShowReviewModal, AppModal},

    data() {
        return {
            selectedOption: "",
            dropdownOptions: ["Low to High", "High to Low", "Most Recent Ad"],
            sortOrderOptions: {
                "Low to High": "price_low_to_high",
                "High to Low": "price_high_to_low",
                "Most Recent Ad": "most_recent"
            },
            priceSlider: 50,
            minPrice: 0,
            range: [0, 200000],
            maxPrice: 100,
            showModal: false,
            showModal1: false,
            data: {},
            info: "",
            query: ""
        };
    },
    setup() {
        const startTime = ref(new Date()); // Initialize startTime with the current date
        console.log(startTime);
        const store = useStore();

        onBeforeUnmount(() => {
            const endTime = new Date();
            const duration = Math.abs(endTime - startTime.value);

            const formattedDate = formatDate(new Date());

            const usageData = {
                date: formattedDate,
                usage: duration
            };

            console.log(usageData);
            store.dispatch("trackUsage", usageData);
        });
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
        ...mapActions(['trackUsage']),
        debouncedFetchAds: debounce(function () {
            const sortOrder = this.sortOrderOptions[this.selectedOption];
            const params = {
                range: this.range,
                query: this.query,
                sortOrder: sortOrder,
                minPrice: this.range[0],
                maxPrice: this.range[1]
            };
            this.$store.dispatch("fetchData", params);
        }, 500),

        closeModel() {
            this.showModal = !this.showModal;
        },
        closeModel1() {
            this.showModal1 = !this.showModal1;
        },
        handlemodal(info) {
            this.info = info;
            this.showModal1 = true;
        },
        update(trip) {
            this.data = trip;
        },
        updateInfo(newValue) {
            this.info = newValue;
        }
    },

    watch: {
        range: {
            handler: "debouncedFetchAds",
            immediate: true
        },
        query: {
            handler: "debouncedFetchAds",
            immediate: true
        },
        selectedOption: {
            handler(newOption) {
                this.sortOrder = this.sortOrderOptions[newOption];
                this.debouncedFetchAds();
            },
            immediate: true
        }
    },
    computed: {
        priceRange: {
            get() {
                return (parseInt(this.minPrice) + parseInt(this.maxPrice)) / 2;
            },
            set(value) {
                const halfRange = (this.maxPrice - this.minPrice) / 2;
                this.minPrice = value - halfRange;
                this.maxPrice = value + halfRange;
            }
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
        ads() {
            return this.$store.getters.filteredAds;
        }
    },
    mounted() {
        this.$store.dispatch("fetchData");
    }
};
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
@media (min-width: 0px) and (max-width: 767px) {
    .margin-top-col{
        margin-top: 10px;
        margin-bottom: 10px;
    }
}
/*@media (min-width: 0px) and (max-width: 992px) {*/
/* .margin-top{*/
/*     margin-top: 10px;*/
/* }*/
/*}*/
::placeholder {
    color: #999999; /* Replace with your desired hex color */
}

.white-slider .v-slider__track-background,
.white-slider .v-slider__thumb {
    background-color: white !important;
}

.v-input__details {
    display: none !important;
}

.my-v-select >>> .v-select__slot input {
}

@media (max-width: 491px) {
    .heading {
        font-size: 5rem !important;
    }
}

.text {
    color: #ffcb00;
    font-family: 'Satisfy', cursive;
    font-size: 2rem;
    font-weight: bolder;
}

@media (max-width: 767px) {
    .row {
        flex-direction: column;
    }
}


.adsowner {
    color: #ffffff;
    font-weight: bold;
}

.background {
    padding: 20px 0px;
    background-color: #212121;
}

.heading {
    text-align: center;
    color: #ffcb00;
    font-family: 'Satisfy', cursive;
    font-size: 6rem;
}


.background-container {
    background-image: url("/assets/z2.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    width: 100%; /* Adjust as needed */
    height: 50vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}


.search {
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);

}

.search input {

    height: 60px;
    text-indent: 30px;
    border: 2px solid #d6d4d400;
    background-color: #ffffff !important;

}


.search input:focus {

    box-shadow: none;
    border: 2px solid blue;


}

.form-control {
    background-color: #003e2e9c !important;
}

.search button {

    position: absolute;
    top: 5px;
    right: 5px;
    height: 50px;
    width: 110px;
    background: blue;

}

.find {
    width: 100%;
    padding-top: 63px;
    padding-bottom: 70px;
    z-index: 0;
    background-image: url("/assets/z1.png");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;

}

.find_background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.find_form_container {
    width: 100%;
    margin-top: 36px;
}

.find_title {
    width: 100%;
    font-size: 30px;
    font-weight: 300;
    color: #FFFFFF;
}

.find_form {
    width: 100%;
    height: 100%;
}

.find_input {
    width: 100%;
    height: 56px;
    border: none;
    outline: none;
    padding-left: 20px;
    padding-right: 20px;
    font-size: 13px;
    font-weight: 400;
    line-height: 52px;
    color: #FFFFFF;
    border: solid 2px rgba(255, 255, 255, 0.5);
    background: transparent;
}

.find_item:first-child {
    width: 100%;
}

.find_item:nth-child(2) {
    width: 100%;
}

.find_item:nth-child(3) {
    width: 100%;
}

.find_item:nth-child(4) {
    width: 100%;
}

.find_item div {
    font-size: 14px;
    font-weight: 400;
    color: #FFFFFF;
    margin-bottom: 7px;
}

.dropdown_item_select {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    -webkit-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
    -webkit-user-select: none;
    background-position: center right;
    background-repeat: no-repeat;
    margin: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    font-size: 14px;
    font-weight: 400;
    font-style: italic;
    color: #939393 !important;
}

.dropdown_item_select::-ms-expand {
    display: none;
}

.find_input:hover {
    border: solid 2px rgba(254, 67, 91, 0.5);
}

.find_input:focus {
    outline-color: rgba(254, 67, 91, 0.5);
    border: solid 2px rgba(254, 67, 91, 0.5);
}

.find_button {
    width: 14.048%;
    height: 56px;
    font-size: 16px;
    font-weight: 500;
    color: #FFFFFF;
    line-height: 52px;
    padding-left: 46px;
    padding-right: 46px;
    background: #fe435b !important;
    -webkit-transform: translateY(14px);
    -moz-transform: translateY(14px);
    -ms-transform: translateY(14px);
    -o-transform: translateY(14px);
    transform: translateY(14px);
    border: none;
    outline: none;
    cursor: pointer;
}

.find_button:hover {
    opacity: 0.8;
}

.find_input::-webkit-input-placeholder {
    font-size: 14px !important;
    font-weight: 400 !important;
    font-style: italic;
    color: #939393 !important;
}

.find_input:-moz-placeholder {
    font-size: 14px !important;
    font-weight: 400 !important;
    font-style: italic;
    color: #939393 !important;
}

.find_input::-moz-placeholder {
    font-size: 14px !important;
    font-weight: 400 !important;
    font-style: italic;
    color: #939393 !important;
}

.find_input:-ms-input-placeholder {
    font-size: 14px !important;
    font-weight: 400 !important;
    font-style: italic;
    color: #939393 !important;
}

.find_input::input-placeholder {
    font-size: 14px !important;
    font-weight: 400 !important;
    font-style: italic;
    color: #939393 !important;
}
</style>
