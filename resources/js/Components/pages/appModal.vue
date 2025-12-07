<template>


    <div :class="{ 'faded-background': loading }">
        <!-- Your regular page content here -->
        <div :class="show?'show modal fade':'modal fade'" id="exampleModal" tabindex="-1"
             :style="show?'display:block':''"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h1 class="modal-title fs-5 " id="exampleModalLabel">CHECKOUT</h1>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="isAuthenticated">
                        <div class="container">
                            <h1 class="h3 mb-5">Payment</h1>
                            <div class="row">
                                <!-- Left -->
                                <div class="col-lg-9">
                                    <div class="accordion" id="accordionPayment">
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#panelsStayOpen-collapseOne"
                                                        aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                                    Description
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseOne"
                                                 class="accordion-collapse collapse show"
                                                 aria-labelledby="panelsStayOpen-headingOne">
                                                <div class="accordion-body">
                                                    {{ form.description }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3">
                                            <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
                                                <div class="form-check w-100 collapsed" data-bs-toggle="collapse"
                                                     data-bs-target="#collapseCC" aria-expanded="false">
                                                    <input class="form-check-input" type="radio" name="payment"
                                                           id="payment1">
                                                    <label class="form-check-label pt-1" for="payment1">
                                                        Credit Card
                                                    </label>
                                                </div>
                                                <span>
                                                <v-icon>mdi-credit-card-fast</v-icon>
                                            </span>
                                            </h2>
                                            <div id="collapseCC" class="accordion-collapse collapse show"
                                                 data-bs-parent="#accordionPayment" style="">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Card Number</label>
                                                        <input type="text" class="form-control" placeholder=""
                                                               v-model="cardNumber"
                                                               @input="validateCardNumber"
                                                               required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Name on card</label>
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Expiry month</label>
                                                                <input type="text" class="form-control" placeholder="MM"
                                                                       v-model="month" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Expiry year</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="YYYY"
                                                                       v-model="year">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">CVV Code</label>
                                                                <input type="password" class="form-control"
                                                                       v-model="cvc" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-3 border">
                                            <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
                                                <div class="form-check w-100 collapsed" data-bs-toggle="collapse"
                                                     data-bs-target="#collapsePP" aria-expanded="false">
                                                    <input class="form-check-input" type="radio" name="payment"
                                                           id="payment2">
                                                    <label class="form-check-label pt-1" for="payment2">
                                                        Submit Query
                                                    </label>
                                                </div>
                                                <span>
                                                <v-icon>mdi-account-plus</v-icon>
              </span>
                                            </h2>
                                            <div id="collapsePP" class="accordion-collapse collapse"
                                                 data-bs-parent="#accordionPayment" style="">
                                                <div class="accordion-body">
                                                    <form class="row" @submit.prevent="handlesubmit">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" v-model="name" class="form-control"
                                                                       required
                                                                       placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Phone Number</label>
                                                                <input type="number" v-model="number"
                                                                       class="form-control" required
                                                                       placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" v-model="email" class="form-control"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                        <textarea type="text" class="form-control"
                                                                  placeholder="message" v-model="message"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-dark mt-3">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right -->
                                <div class="col-lg-3">

                                    <div class="card position-sticky top-0">
                                        <div class="p-3 bg-light bg-opacity-10">
                                            <img :src="this.form.image" class="card-img-top card-img-bottom" alt="...">
                                            <div class="ad_detail_summary">
                                                <h6 class="card-title mb-3 pt-3">Order Detail</h6>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Place</span> <span
                                                    class="text-capitalize">{{ form.title }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Person Required</span> <span>{{ form.personCount }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Days</span> <span>{{ form.days }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Night</span> <span>{{ form.nights }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Meal</span> <span
                                                    class="text-uppercase">{{ form.meal }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Bonfire</span> <span
                                                    class="text-uppercase">{{ form.bonfire }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Tour guide</span> <span
                                                    class="text-uppercase">{{ form.tourGuide }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Date of departure</span> <span
                                                    class="text-uppercase">{{
                                                        formattedValidationDate(form.validationdate)
                                                    }}</span>
                                                </div>
                                                <hr>
                                            </div>
                                            <h6 class="card-title mb-3">Order Summary</h6>
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Subtotal</span> <span
                                                class="font-weight-bold">Rs. {{ form.price }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between mb-4 small">
                                                <span>TOTAL</span> <strong class="text-dark">Rs.
                                                {{ form.price }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body" v-else>
                        <div class="container">
                            <div class="row">
                                <!-- Left -->
                                <div class="col-lg-9">
                                    <h1 class="h3 mb-5">Login</h1>
                                    <h6 class="mb-3">Please login to your account first.</h6>
                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                        aria-controls="panelsStayOpen-collapseOne">
                                                    Description
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                                 aria-labelledby="panelsStayOpen-headingOne">
                                                <div class="accordion-body">
                                                    {{ form.description }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right -->
                                <div class="col-lg-3">

                                    <div class="card position-sticky top-0">
                                        <div class="p-3 bg-light bg-opacity-10">
                                            <img :src="this.form.image" class="card-img-top card-img-bottom" alt="...">
                                            <div class="ad_detail_summary">
                                                <h6 class="card-title mb-3 pt-3">Order Detail</h6>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Place</span> <span
                                                    class="text-capitalize">{{ form.title }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Person Required</span> <span>{{ form.personCount }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Days</span> <span>{{ form.days }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Night</span> <span>{{ form.nights }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Meal</span> <span
                                                    class="text-uppercase">{{ form.meal }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Bonfire</span> <span
                                                    class="text-uppercase">{{ form.bonfire }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Tour guide</span> <span
                                                    class="text-uppercase">{{ form.tourGuide }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span>Date of departure</span> <span
                                                    class="text-uppercase">{{
                                                        formattedValidationDate(form.validationdate)
                                                    }}</span>
                                                </div>
                                                <hr>
                                            </div>
                                            <h6 class="card-title mb-3">Order Summary</h6>
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Subtotal</span> <span
                                                class="font-weight-bold">Rs. {{ form.price }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between mb-4 small">
                                                <span>TOTAL</span> <strong class="text-dark">Rs.
                                                {{ form.price }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer" v-if="isAuthenticated">
                        <router-link to="user-receipt" class="btn btn-dark" v-if="getshowbuttonresponse">Show Receipt
                        </router-link>
                        <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary" @click="handlepay">Pay</button>
                    </div>
                    <div class="modal-footer" v-else>
                        <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                        </button>
                        <router-link to="login" class="btn btn-primary">Proceed to Login</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="centered-content">
            <div class="wrapper">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'appModal',
    props: ['show', 'data'],
    computed: {
        ...mapGetters(["isAuthenticated", "getuserinfo", "getshowbuttonresponse", "getsubmitcontactresponse"]),
        userinfo() {
            return this.getuserinfo.id;
        },
        userfirstname() {
            return this.getuserinfo.firstname;
        },
        userlastname() {
            return this.getuserinfo.lastname;
        },
        useremail() {
            return this.getuserinfo.email;
        },
        userid() {
            return this.getuserinfo.id;
        },
        formattedValidationDate() {
            return (validationdate) => {
                const date = new Date(validationdate);
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            };
        },
    },
    data() {
        return {
            showCenteredContent: false,
            cvc: '',
            month: '',
            year: '',
            cardNumber: '',
            email: '',
            message: '',
            number: '',
            name: '',
            response: '',
            loading: false,
            // successURL: 'http://google.com',
            // cancelURL: '',
            stripeToken: '',
            form: {
                user_id: "",
                id: "",
                title: "",
                price: null,
                days: null,
                nights: null,
                personCount: null,
                meal: "",
                bonfire: "",
                tourGuide: "",
                description: "",
                image: null,
                firstname: '',
                lastname: '',
                email: '',
                auth_user_id: '',
                validationdate: '',
            }
        }
    },
    watch: {
        data: {
            immediate: true,
            handler(newTrip) {
                this.form.user_id = newTrip.user_id;
                this.form.id = newTrip.id;
                this.form.title = newTrip.place;
                this.form.price = newTrip.price;
                this.form.days = newTrip.days;
                this.form.nights = newTrip.night;
                this.form.personCount = newTrip.person;
                this.form.meal = newTrip.meal;
                this.form.bonfire = newTrip.bonfire;
                this.form.tourGuide = newTrip.tourguide;
                this.form.description = newTrip.description;
                this.form.image = newTrip.image;
                this.form.validationdate = newTrip.validationdate;
                this.myFunction();
                this.callfunction();
            }
        },
    },
    mounted() {

    },
    methods: {
        validateCardNumber() {
            // Remove any non-digit characters from the card number
            this.cardNumber = this.cardNumber.replace(/\D/g, '');

            // Restrict the card number to 16 characters
            if (this.cardNumber.length > 16) {
                this.cardNumber = this.cardNumber.slice(0, 16);
            }
        },
        ...mapActions(['processpayment', 'UpdateReceiptState', 'checkTransaction']),
        async handlepay() {
            const stripe = require('stripe')('pk_test_51N1v9ICmXVqoMpIrAxCprZ01ktSsXZKaSldTOjnyN760s2TjSO44Qaptir6qcSlrjfBRVJqDhDu3WJKLxHOWGw4C00TSdCKqWp');

            try {
                const cardToken = await stripe.tokens.create({
                    card: {
                        number: this.cardNumber,
                        exp_month: this.month,
                        exp_year: this.year,
                        cvc: this.cvc,
                    },
                });

                const paymentData = {
                    user_id: this.userinfo,
                    ad_id: this.form.id,
                    stripeToken: cardToken.id,
                    ad_owner_id: this.form.user_id
                };

                this.loading = true;
                await this.processpayment(paymentData);
                const userId = this.form.user_id; // Replace with the ID of the user who purchased the ad
                const adId = this.form.id;
                this.$store.dispatch('removePurchasedAd', { userId, adId });
            } catch (e) {
                this.$store.commit('SET_MESSAGE_RESPONSE', e);
                this.$store.commit('SET_MESSAGE_COLOR', "danger")
                setTimeout(() => {
                    this.$store.commit('SET_MESSAGE_RESPONSE', "")
                    this.$store.commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
            } finally {
                this.loading = false;
                this.callfunction();
                this.close()
            }
        },
        myFunction() {
            this.form.firstname = this.userfirstname;
            this.form.lastname = this.userlastname;
            this.form.email = this.useremail;
            this.form.auth_user_id = this.userid;
            this.UpdateReceiptState(this.form)
        },
        callfunction() {
            this.checkTransaction({userId: this.form.auth_user_id, adId: this.form.id});
        },
        close() {
            this.$emit('close')
        },
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
    }
};

</script>
<style scoped>
.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0, 0, 0, .125);
    border-radius: 1rem;
}

textarea.form-control {
    min-height: calc(7.5em + 0.75rem + 2px) !important;
}

.faded-background {
    position: relative;
}

.faded-background::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9998;
}

.centered-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    padding: 20px;
    color: white;
    text-align: center; /* Center the content horizontally */
}

.wrapper {
    width: 200px;
    height: 60px;
    position: relative;
    z-index: 1;
}

.circle {
    width: 20px;
    height: 20px;
    position: absolute;
    border-radius: 50%;
    background-color: #fff;
    left: 15%;
    transform-origin: 50%;
    animation: circle7124 .5s alternate infinite ease;
}

@keyframes circle7124 {
    0% {
        top: 60px;
        height: 5px;
        border-radius: 50px 50px 25px 25px;
        transform: scaleX(1.7);
    }

    40% {
        height: 20px;
        border-radius: 50%;
        transform: scaleX(1);
    }

    100% {
        top: 0%;
    }
}

.circle:nth-child(2) {
    left: 45%;
    animation-delay: .2s;
}

.circle:nth-child(3) {
    left: auto;
    right: 15%;
    animation-delay: .3s;
}

.shadow {
    width: 20px;
    height: 4px;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.9);
    position: absolute;
    top: 62px;
    transform-origin: 50%;
    z-index: -1;
    left: 15%;
    filter: blur(1px);
    animation: shadow046 .5s alternate infinite ease;
}

@keyframes shadow046 {
    0% {
        transform: scaleX(1.5);
    }

    40% {
        transform: scaleX(1);
        opacity: .7;
    }

    100% {
        transform: scaleX(.2);
        opacity: .4;
    }
}

.shadow:nth-child(4) {
    left: 45%;
    animation-delay: .2s
}

.shadow:nth-child(5) {
    left: auto;
    right: 15%;
    animation-delay: .3s;
}


</style>

