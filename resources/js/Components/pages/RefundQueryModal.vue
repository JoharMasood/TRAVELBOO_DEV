<template>
    <!-- Modal -->
    <div
        :class="show ? 'show modal fade' : 'modal fade'"
        id="exampleModal"
        tabindex="-1"
        :style="show ? 'display:block' : ''"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5 " id="exampleModalLabel">DELETE</h1>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="!showButton">
                    <div class="ad-note0">
                        <p><strong>Important Notice:</strong></p>
                        <p>We regret to inform you that the cancellation deadline for your reservation has passed, and
                            we are unable to process a refund at this time.</p>
                        <p>As per our policy, refund requests are only accepted until three days prior to the departure date.</p>
                    </div>
                </div>
                <div class="modal-body" v-if="showButton">
                    Are you sure you want to cancel your reservation?
                    <div class="ad-note">
                        <p><strong>Important Notice:</strong></p>
                        <p>The refund amount will be credited back to your account within 2-3 working days.</p>
                        <p>Please be aware that you have the option to cancel your reservation until three days prior to
                            the departure date. After this date, you will not be able to cancel your reservation.
                            Therefore, we kindly request you to review your plans and make any necessary changes or
                            cancellations before the deadline.</p>
                        <p>Please note that once you have requested the cancellation of your reservation, your current
                            receipt will no longer be valid.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">No
                    </button>
                    <button type="button" class="btn btn-danger" :disabled="!showButton" @click="handlerefund()">Request a refund</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "RefundQueryModal",
    props: ['show', 'data'],
    data() {
        return {
            image: "",
            first_name: "",
            last_name: "",
            ad_id: "",
            targetDate: "",
        }
    },
    computed: {
        ...mapGetters(['getuserinfo']),
        showButton() {
            const [year, month, day] = this.targetDate.split('-'); // Split the targetDate into year, month, and day
            const targetTimestamp = new Date(year, month - 1, day).getTime(); // Convert target date to timestamp (subtract 1 from month since it is zero-based)
            const currentTimestamp = new Date().getTime(); // Get current timestamp
            const threeDaysInMilliseconds = 3 * 24 * 60 * 60 * 1000; // Calculate three days in milliseconds

            // Calculate the difference between target and current timestamps
            const difference = targetTimestamp - currentTimestamp;

            // Check if the difference is greater than three days in milliseconds
            return difference >= threeDaysInMilliseconds;
        },
    },
    methods: {
        close() {
            this.$emit('close');
        },
        ...mapActions(['deleteAd']),
        handlerefund() {
            const userInfo = this.getuserinfo;
            const {image, firstname, lastname} = userInfo;

            this.$store.dispatch('createRefundRequest', {
                ad_id: this.ad_id,
                image,
                firstname,
                lastname
            })
                .then(() => {
                    this.close();
                })
                .catch(error => {
                    console.log('Error deleting ad:', error);
                });
        }
    },
    watch: {
        data: {
            immediate: true,
            handler(newTrip) {
                if (newTrip && newTrip.ads && newTrip.ads.length > 0) {
                    this.ad_id = newTrip.ads[0].id;
                    this.targetDate = newTrip.ads[0].validationdate
                }
            }
        },
    },
    mounted() {

    },
};

</script>

<style scoped>
.ad-note {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    padding: 10px;
    margin-top: 20px;
    font-size: 14px;
}

.ad-note p {
    margin: 0 0 10px;
}

.ad-note strong {
    font-weight: bold;
}
.ad-note0 {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 14px;
}

.ad-note0 p {
    margin: 0 0 10px;
}

.ad-note0 strong {
    font-weight: bold;
}
</style>

