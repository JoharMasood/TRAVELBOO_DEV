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
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirm to send refund
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" @click="handleRefund">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    name: "ConfirmRefundModalAdminPanel",
    props: ["show","data"],
    data() {
        return {
          ad_id: "",
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.ad_id = newValue;
                }
            },
        },
    },
    methods: {
        ...mapActions(['refundPayment']),
        handleRefund() {
            const adId = this.ad_id; // Set the ad ID as per your requirement
            this.refundPayment(adId);
            this.$store.dispatch("fetchRefundRequests")
            this.close();
        },
        close() {
            this.$emit("close");
        },

    },
};
</script>

<style scoped>
/* Your scoped styles here */
</style>
