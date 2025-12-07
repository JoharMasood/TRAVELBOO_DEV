<template>
    <!-- Modal -->
    <div :class="show ? 'show modal fade' : 'modal fade'" id="exampleModalScrollable" tabindex="-1"
         :style="show ? 'display:block' : ''" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">PURCHASES</h1>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-if="informations.length === 0">No purchase information available.</div>
                    <div class="d-flex purchased-section" v-for="(information, index) in informations" :key="index">
                        <img :src="information.buyer_profile || defaultImage" alt="" class="avatar">
                        <div class="content">
                            <h4>Purchased by:</h4>
                            <span class="username">{{ information.buyer_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";

    export default {
        name: 'PurchasedAdsModal',
        props: ['show'],
        data(){
            return {
                defaultImage: "storage/avatar/default.png",
            }
        },
        computed: {
            ...mapGetters(['getpurchaseresponse']),
            informations() {
                return this.getpurchaseresponse;
            },

        },
        methods: {
            close() {
                this.$emit('close');
            },
        }
    };
</script>

<style scoped>
    .purchased-section {
        border: 1px solid black;
        border-radius: 20px;
        padding: 10px;
    }

    .avatar {
        height: 70px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .content {
        display: flex;
        align-items: center;
    }

    h4 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .username {
        margin-left: 10px;
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }
</style>
