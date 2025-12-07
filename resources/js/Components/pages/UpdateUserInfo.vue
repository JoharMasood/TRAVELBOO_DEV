<template >
<div class="min-height">
    <div class="container">
        <div class="heading">
            <h1 class="text-center text_styling">Update account information</h1>

        </div>
        <form class="form" @submit.prevent="handlesubmit">

            <label>First Name</label>
            <input type="text" class="form-control" id="exampleInputFirstName1" aria-describedby="firstnamehelp" v-model="form.first_name" required autocomplete="off">



            <label>Last Name</label>
            <input type="text" class="form-control" id="exampleInputLastName1" aria-describedby="lastnamehelp" v-model="form.last_name" autocomplete="off" required>



            <label>Current Password</label>
            <input type="password" class="form-control" id="exampleInputCurrentPassword1" aria-describedby="currentpasswordhelp" placeholder="Enter Current Password" autocomplete="off" v-model="form.old_password" required>



            <label >New Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" v-model="form.new_password"  placeholder="Enter New Password" autocomplete="off">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "UpdateUserInfo",
        data() {
            return {
                form: {
                    first_name: "",
                    last_name: "",
                    old_password: '',
                    new_password: '',
                },
            }
        },
        computed: {
            ...mapGetters(['getuserinfo']),
            userfirstname() {
                this.form.first_name = this.getuserinfo.firstname;
            },
            usersecondname() {
                this.form.last_name = this.getuserinfo.lastname;
            },
        },
        methods: {
            ...mapActions(['updateauthuserinfo']),
            populateFormFields() {
                this.form.first_name = this.getuserinfo.firstname;
                this.form.last_name = this.getuserinfo.lastname;
            },
            handlesubmit() {
                const userinfo = {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    old_password: this.form.old_password,
                    new_password: this.form.new_password,
                };
                this.updateauthuserinfo(userinfo)
            }
        },
        mounted() {
            this.populateFormFields();
        }
    }
</script>

<style scoped>
.min-height{
    min-height: 100vh;
}
    .text_styling{
        font-family: 'IBM Plex Mono', monospace;
        font-weight: bolder;
        text-align: center;
    }
    .form label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .heading {
        margin: 100px 0px;
    }

    .form input {
        display: block;
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }
</style>
