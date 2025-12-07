<template>
    <div class="galp">
        <div class="review-section">
            <h3 class="text-center mb-10" style="background-color: dimgrey;
    padding: 20px 0px;
    color: #fff;">Users Reviews</h3>
            <div class="container">
                <div class="scrollable-div">
                    <input type="text" v-model="searchQuery" @input="debouncedFetchReviews" placeholder="Search"
                           class="form-control mb-3"/>
                    <div class="hvr-sweep-to-right mb-10"
                         v-for="review in filteredReviews" :key="review.id"
                         @click="openModal(review.review_id,review.user_id,review.reviewer_id)"
                    >
                        <div class="d-flex justify-space-between">
                            <div>
                                <img :src="review.user_image || defaultImage" alt="" class="avatar"/>
                                <span class="email mr-5">{{ review.user_name }}</span>
                            </div>
                            <div>
                                <span style="color: dimgrey;">Reviewed by: </span>
                                <span class="email mr-5">{{ review.reviewer_name }}</span>
                                <img :src="review.reviewer_image || defaultImage" alt="" class="avatar"/>
                            </div>
                        </div>
                        <div class="mt-3">
                            {{ review.comment }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h3 class="text-center mb-10" style="background-color: dimgrey;
    padding: 20px 0px;
    color: #fff;">Users Queries</h3>
            <div class="container" style="overflow-x: auto;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(contact, index) in contacts" :key="contact.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phonenumber }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.message }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="options-container">
                    <select class="form-select" v-model="selectedOption" @change="fetchData">
                        <option value="last_7_days">Last 7 Days</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="last_1_year">Last 1 Year</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <DeleteReviewConfirmationModal
        :show="showModal"
        :review_id="review_id"
        :user_id="user_id"
        :reviewer_id="reviewer_id"
        @close="closeModal"
    />
    <div class="modal-backdrop fade show" v-if="showModal"></div>
</template>

<script>
import {mapActions, mapGetters, mapState} from 'vuex';
import {debounce} from "lodash";
import DeleteReviewConfirmationModal from "./DeleteReviewConfirmationModal";

export default {
    name: 'Reviews&ContactsAdminPanel',
    data() {
        return {
            selectedOption: 'last_7_days',
            searchQuery: '',
            defaultImage: '/assets/default.png',
            showModal: false,
            review_id: '',
            user_id: '',
            reviewer_id: '',
        };
    },
    computed: {
        ...mapState(['contacts']),
        ...mapGetters(['allReviews']),
        filteredReviews() {
            if (this.searchQuery) {
                return this.allReviews.filter(review =>
                    review.comment.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            } else {
                return this.allReviews;
            }
        }
    },
    created() {
        this.fetchContacts(this.selectedOption);
    },
    methods: {
        ...mapActions(['fetchContacts']),
        fetchData(){
            this.fetchContacts(this.selectedOption)
        },
        openModal(review_id, user_id, reviewer_id) {
            this.review_id = review_id;
            this.user_id = user_id;
            this.reviewer_id = reviewer_id;
            this.showModal = true;
        },
        closeModal() {
            this.selectedUserId = null;
            this.showModal = false;
        },
        ...mapActions(['fetchReviews']),
        debouncedFetchReviews: debounce(function () {
            const params = {
                query: this.searchQuery,
            };
            this.$store.dispatch("fetchReviews", params);
        }, 500),
    },
    watch: {
        searchQuery: {
            handler: "debouncedFetchReviews",
            immediate: true
        },
    },
    mounted() {
        this.$store.dispatch("fetchReviews");
    }
};
</script>

<style scoped>
.galp{
    min-height: 100vh;
}
.options-container {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}

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

.avatar {
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}
.table td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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

.scrollable-div {
    min-height: 500px; /* Set the desired height for the scrollable div */
    overflow-y: auto; /* Enable vertical scrolling */
    /* Additional styles as needed */
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
}
</style>
