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
                    You really want to delete this review?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" @click="handleDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    name: "DeleteReviewConfirmationModal",
    props: ["show","review_id","user_id","reviewer_id"],
    data() {
        return {
            info: {
                user_id: "",
                review_id: "",
                reviewer_id: "",
            },
        };
    },
    watch: {
        show: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.info.review_id = this.review_id;
                    this.info.user_id = this.user_id;
                    this.info.reviewer_id = this.reviewer_id;
                }
            },
        },
    },
    methods: {
        close() {
            this.$emit("close");
        },
        handleDelete() {
            const reviewInfo = {
                user_id: this.info.user_id,
                reviewer_id: this.info.reviewer_id,
                id: this.info.review_id
            };
            this.$store.dispatch('deleteReview', reviewInfo)
            this.$emit("close");
        },
        ...mapActions(["deleteUser"]),
    },
};
</script>

<style scoped>
/* Your scoped styles here */
</style>
