<template>
    <div class="section-users">
        <h3 class="text-center mb-5" style="background-color: dimgrey;
    padding: 20px 0px;
    color: #fff;">Refund Queries</h3>
        <div class="container">
            <div class="scrollable-div">
                <div
                    class="hvr-sweep-to-right mb-10 d-flex flex-column flex-sm-row align-items-center"
                    v-for="(user, index) in getData"
                    :key="index"
                    @click="openModal(user.ad_id)"
                >
                    <div class="flex-fill">
                        <img :src="user.image || defaultimage" alt="" class="avatar"/>
                    </div>
                    <div class="flex-fill">
        <span class="username mr-5"
        >Name: {{ getFullName(user.firstname, user.lastname) }}</span
        >
                    </div>
                    <div class="flex-fill">
        <span class="created-at"
        >Message: {{ user.message }}</span
        >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ConfirmRefundModalAdminPanel
        :show="showModal"
        :data="ad_id"
        @close="closeModal"
    ></ConfirmRefundModalAdminPanel>
    <div class="modal-backdrop fade show" v-if="showModal"></div>

</template>
<script>
import {mapGetters} from "vuex";
import ConfirmRefundModalAdminPanel from "./ConfirmRefundModalAdminPanel.vue";

export default {
    name: "RefundQueriesAdminPanel",
    components: [ConfirmRefundModalAdminPanel],
    data() {
        return {
            defaultimage: '/assets/default.png',
            showModal: false,
            ad_id: "",
        }
    },
    methods: {

        getFullName(firstName, lastName) {
            const capitalizedFirstName =
                firstName.charAt(0).toUpperCase() + firstName.slice(1);
            const capitalizedLastName =
                lastName.charAt(0).toUpperCase() + lastName.slice(1);
            return `${capitalizedFirstName} ${capitalizedLastName}`;
        },
        openModal(id) {
            this.ad_id = id;
            this.showModal = true;
        },
        closeModal() {
            this.ad_id = null;
            this.showModal = false;
        },
    },
    computed: {
        ...mapGetters(['getrefundedadsadminpanel']),
        getData() {
            return this.getrefundedadsadminpanel;
        }
    },
    mounted() {
        this.$store.dispatch('fetchRefundRequests')
    }
}
</script>
<style scoped>
.scrollable-div {
    min-height: 85.6vh; /* Set the desired height for the scrollable div */
    overflow-y: auto; /* Enable vertical scrolling */
    /* Additional styles as needed */
}

/* Sweep To Right */
.hvr-sweep-to-right {
    padding: 30px;
    background: lightgrey;
    display: inline-block;
    transform: perspective(1px) translateZ(0);
    position: relative;
    transition: color 0.3s;
    border-radius: 10px;
    width: 100%;
    cursor: pointer;
}

.hvr-sweep-to-right:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    background: #2098d1;
    transform: scaleX(0);
    transform-origin: 0 50%;
    transition: transform 0.3s ease-out;
    border-radius: 10px;
}

.hvr-sweep-to-right:hover {
    color: white;
    border-radius: 10px;
}

.hvr-sweep-to-right:hover:before {
    transform: scaleX(1);
}

.avatar {
    height: 70px;
    border-radius: 50%;
    margin-right: 10px;
}

@media (max-width: 767px) {
    .hvr-sweep-to-right {
        padding: 10px;
        width: 100%;
    }

    .avatar {
        height: 50px;
        margin-right: 5px;
    }

    .content {
        margin-left: 5px;
    }
}
</style>
