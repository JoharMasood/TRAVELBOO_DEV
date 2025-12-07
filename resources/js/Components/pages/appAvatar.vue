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
                    <div class="avatar-grid">
                        <div
                            v-for="(avatar, index) in avatars"
                            :key="index"
                            class="avatar-item"
                            @click="selectAvatar(avatar)"
                            :class="{ 'selected': avatar === selectedAvatar }"
                        >
                            <img :src="avatar" alt="Avatar"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-primary" @click="updateProfileAvatar">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from "vuex";
    export default {
        name: "appAvatar",
        props: ['show'],
        data() {
            return {
                avatars: [
                    'storage/avatar/aa1.png',
                    'storage/avatar/a2.png',
                    'storage/avatar/a3.png',
                    'storage/avatar/a4.png',
                    'storage/avatar/a5.png',
                    'storage/avatar/a6.png',
                    'storage/avatar/a7.png',
                    'storage/avatar/a8.png',
                ],
                selectedAvatar: '',
            };
        },
        methods: {
            close() {
                this.$emit('close');
            },
            selectAvatar(avatar) {
                this.selectedAvatar = avatar;
            },
            ...mapActions(['updateProfilePic']),
            async updateProfileAvatar() {
                if (!this.selectedAvatar) {
                    // Handle the case when no avatar is selected
                    console.warn('No avatar selected');
                    return;
                }
                try {
                    await this.updateProfilePic(this.selectedAvatar);
                    console.log("Profile picture updated successfully");
                    this.$store.dispatch("userinfo");
                    this.close(); // Close the modal
                } catch (error) {
                    console.error("Failed to update profile picture:", error);
                }
            },
        },
    };
</script>


<style scoped>
    .avatar-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        max-height: 300px; /* Adjust the height as needed */
        overflow-y: auto;
    }

    .avatar-item {
        cursor: pointer;
        position: relative;
    }

    .avatar-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-item.selected:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1;
        pointer-events: none;
        border-radius: 100px;
    }
</style>
