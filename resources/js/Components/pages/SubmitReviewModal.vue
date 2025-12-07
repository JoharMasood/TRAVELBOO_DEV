<template>
    <div :class="show ? 'show modal fade' : 'modal fade'" id="exampleModal" tabindex="-1"
         :style="show ? 'display:block' : ''" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group d-flex align-center">
                        <label for="rating">Rating:</label>
                        <div class="rating ml-3">
                            <span class="star" v-for="n in 5" :key="n" @click="setRating(n)">
                                 <i :class="['mdi', n <= selectedRating ? 'mdi-star' : 'mdi-star-outline']"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control" id="comment" rows="4" v-model="comment" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-primary" @click="handleReview">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "SubmitReviewModal",
        props: ['show', 'data'],
        data() {
            return {
                ad_owner_id: "",
                ad_reviewer_id: "",
                selectedRating: 0,
                comment: '',
            };
        },
        watch: {
            data: {
                immediate: true,
                handler(newTrip) {
                    this.ad_owner_id = newTrip.ad_owner_id;
                    this.ad_reviewer_id = newTrip.reviewer_id;
                }
            },
        },
        methods: {
            close() {
                this.$emit('close');
            },
            setRating(rating) {
                this.selectedRating = rating;
            },
            ...mapActions(['submitReview']),
            handleReview() {
                const jnforms = {
                    ad_owner_id: this.ad_owner_id,
                    reviewer_id: this.ad_reviewer_id,
                    rating: this.selectedRating,
                    comment: this.comment,
                };
                this.submitReview(jnforms);
                this.close();
            }
        }
    };
</script>

<style scoped>
    .rating {
        align-items: center;
        font-size: 24px;
    }

    .rating .star {
        cursor: pointer;
        color: orange;
        transition: color 0.2s;
    }

    .rating .star:hover {
        color: orange;
    }
</style>
