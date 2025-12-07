<template>
    <v-snackbar v-model="show" :timeout="timeout" :color="color" :multi-line="multiLine" :vertical="vertical" :bottom="bottom" v-if="message">
        {{ message }}
    </v-snackbar>
</template>

<script>
export default {
    name: "Snackbar",
    props: {
        message: {
            type: String,
            required: true
        },
        timeout: {
            type: Number,
            default: 3000
        },
        color: {
            type: String,
            default: 'primary'
        },
        multiLine: {
            type: Boolean,
            default: false
        },
        vertical: {
            type: Boolean,
            default: false
        },
        bottom: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            show: false
        };
    },
    watch: {
        message: {
            immediate: true,
            handler(newMessage) {
                this.show = !!newMessage;
            }
        }
    }
};
</script>
