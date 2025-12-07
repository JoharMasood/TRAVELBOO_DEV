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
                <div class="modal-body">
                    You really want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-dark" @click="handledelete(data)">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "AdminPanelConfirmDeleteModal",
    props: ['show', 'data'],
    data() {
        return {}
    },
    methods: {
        close() {
            this.$emit('close');
        },
        ...mapActions(['deleteUser']),
        handledelete(userId) {
            // console.log(userId)
            this.deleteUser(userId)
                .then(() => {
                    console.log('User deleted successfully.');
                })
                .catch(error => {
                    console.error('An error occurred while deleting the user:', error);
                })
                .finally(
                this.$emit('close')
            );
        }
    },
    mounted() {

    },
};
</script>

<style scoped>
</style>
