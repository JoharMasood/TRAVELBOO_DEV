<template>
    <div class="bg-img">

        <div class="content">

            <header>Login</header>
            <form @submit.prevent="handleLogin">


                <div class="field">
                    <span><v-icon>mdi-account</v-icon></span>
                    <input type="text" required placeholder="Email" v-model="em">
                </div>
                <div class="field space">
                    <span><v-icon>mdi-lock</v-icon></span>
                    <input type="password" class="pass-key" required placeholder="Password" v-model="pwd">
                    <span class="showw">SHOW</span>
                </div>
                <div class="field">
                    <input type="submit" value="LOGIN">
                </div>
            </form>
            <div class="signup mt-3">
                Don't have account?
                <router-link to="Signup">Sign Up</router-link>
            </div>

        </div>

    </div>

</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        components: {
            // Snackbar,
        },
        name: "Login",
        data() {
            return {
                em: "",
                pwd: "",
            }
        },
        computed: {

        },
        methods: {
            ...mapActions(['login']),
            async handleLogin() {
                try {
                    await this.login({email: this.em, password: this.pwd});
                    this.$store.dispatch("userinfo");
                } catch (error) {
                    console.error('Login failed:', error);
                }
            }
        },
        mounted() {
            const pass_field = document.querySelector('.pass-key');
            const showBtn = document.querySelector('.showw');
            showBtn.addEventListener('click', function() {
                if (pass_field.type === 'password') {
                    pass_field.type = 'text';
                    showBtn.textContent = 'HIDE';
                    showBtn.style.color = '#3498db';
                } else {
                    pass_field.type = 'password';
                    showBtn.textContent = 'SHOW';
                    showBtn.style.color = '#222';
                }
            });
        },
    }
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Poppins:400,500&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        user-select: none;
    }
    .bg-img{
        background: url('/assets/banner.png');
        height: 100vh;
        background-size: cover;
        background-position: center;
    }
    .bg-img:after{
        position: absolute;
        content: '';
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        /*background: rgba(0,0,0,0.7);*/
    }
    .content{
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 999;
        text-align: center;
        padding: 60px 32px;
        width: 370px;
        transform: translate(-50%,-50%);
        background: rgba(255,255,255,0.04);
        box-shadow: -1px 4px 28px 0px rgba(0,0,0,0.75);
    }
    .content header{
        color: white;
        font-size: 33px;
        font-weight: 600;
        margin: 0 0 35px 0;
        font-family: 'Montserrat',sans-serif;
    }
    .field{
        position: relative;
        height: 45px;
        width: 100%;
        display: flex;
        background: rgba(255,255,255,0.94);
    }
    .field span{
        color: #222;
        width: 45px;
        line-height: 45px;
    }
    .field input{
        height: 100%;
        width: 100%;
        background: transparent;
        border: none;
        outline: none;
        color: #222;
        font-size: 14px;
        font-family: 'Poppins',sans-serif;
    }
    .space{
        margin-top: 16px;
        margin-bottom: 16px;
    }
    .showw{
        position: absolute;
        right: 13px;
        font-size: 13px;
        font-weight: 700;
        color: #222;
        display: none;
        cursor: pointer;
        font-family: 'Montserrat',sans-serif;
    }
    .pass-key:valid ~ .showw{
        display: block;
    }
    .pass{
        text-align: left;
        margin: 10px 0;
    }
    .pass a{
        color: white;
        text-decoration: none;
        font-family: 'Poppins',sans-serif;
    }
    .pass:hover a{
        text-decoration: underline;
    }
    .field input[type="submit"]{
        background: #3498db;
        border: 1px solid #2691d9;
        color: white;
        font-size: 14px;
        letter-spacing: 1px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Montserrat',sans-serif;
    }
    .field input[type="submit"]:hover{
        background: #2691d9;
    }
    .signup{
        font-size: 15px;
        color: white;
        font-family: 'Poppins',sans-serif;
    }
    .signup a{
        color: #3498db;
        text-decoration: none;
    }
    .signup a:hover{
        text-decoration: underline;
    }
</style>
