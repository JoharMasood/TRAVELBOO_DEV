<template>
    <div :class="show?'show modal fade':'modal fade'" id="exampleModal" tabindex="-1" :style="show?'display:block':''"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5 " id="exampleModalLabel">REVIEWS</h1>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div v-if="loading" class="d-flex justify-content-center px-5">
                        <div class="loader"></div>
                    </div>
                    <div v-else-if="!reviews || reviews.length === 0">No records found</div>
                    <div v-else class="review" v-for="review in getreviews">
                        <div class="d-flex align-center">
                            <v-avatar size="55" class="avatar">
                                <img :src="review.reviewer_avatar" style="height: 100%; width: 100%;" alt="Avatar">
                            </v-avatar>
                            <div class="name ml-3">{{ review.reviewer_name }}</div>
                            <v-rating v-model="review.rating" :half-increments="true" :readonly="true" size="30" class="ml-3" color="orange"></v-rating>
                        </div>
                        <div class="comment mt-3">{{ review.comment }}</div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapActions, mapGetters, mapMutations} from "vuex";

    export default {
        name: "ShowReviewModal",
        props: ['show', 'info'],
        data() {
            return {
                comment: 'asdsadasdasdas',
                name: 'sadasdsa',
                user_id: '',
                avatarSrc: 'assets/avatars/Default.png',
                rating: 3,
                loading:'',
            };
        },
        computed:{
          ...mapGetters(['getreviews']),
            reviews() {
              return this.getreviews;
            }
        },
        watch: {
            info: {
                immediate: true,
                handler(newTrip) {
                    this.user_id = newTrip.user_id;
                    this.myfunction();
                }
            },
        },
        methods: {
            ...mapMutations(['SET_RATINGS_AND_COMMENTS']),
            ...mapActions(['fetchRatingsAndComments']),
            async myfunction() {
                this.loading = true;
                await this.fetchRatingsAndComments(this.info.user_id);
                this.loading = false;
            },
            close() {
                this.$emit('close');
                this.SET_RATINGS_AND_COMMENTS(null);
                this.$emit('update:info', ''); // Set the 'info' prop to null
            }
        }
    };
</script>

<style scoped>
    .review {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .review .name {
        font-weight: bold;
    }
    .comment {
        margin-top: 8px;
    }
    .loader {
        border: 4px solid rgba(0, 0, 0, .1);
        border-left-color: transparent;
        border-radius: 50%;
    }

    .loader {
        border: 4px solid rgba(0, 0, 0, .1);
        border-left-color: transparent;
        width: 55px;
        height: 55px;
    }
    .loader {
        border: 4px solid rgba(0, 0, 0, .1);
        border-left-color: transparent;
        width: 36px;
        height: 36px;
        animation: spin89345 1s linear infinite;
    }

    @keyframes spin89345 {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>


