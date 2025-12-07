<template>
    <div class="bg-img">
        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                            <h6 class="signup">
                                Already a member?
                                <router-link to="Login">Sign In</router-link>
                            </h6>
                            <h6 class="mb-0 pb-3"><span>register as user</span><span>register as company</span></h6>
                            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <form class="section text-center" @submit.prevent="handleuserRegister">
                                                <div class="field">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="First Name" v-model="firstName">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="Last Name" v-model="lastName">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="Email" v-model="email">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-lock</v-icon></span>
                                                    <input type="password" class="pass-key" required placeholder="Password" v-model="password">
                                                    <span class="showw">SHOW</span>
                                                </div>
                                                <div class="field space">
                                                    <input type="submit" value="SIGNUP">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <form class="section text-center" @submit.prevent="handlecompanyRegister">
                                                <div class="field">
                                                    <span><v-icon>mdi-domain</v-icon></span>
                                                    <input type="text" required placeholder="Company Name" v-model="company">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="First Name" v-model="firstName">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="Last Name" v-model="lastName">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-account</v-icon></span>
                                                    <input type="text" required placeholder="Email" v-model="email">
                                                </div>
                                                <div class="field space">
                                                    <span><v-icon>mdi-lock</v-icon></span>
                                                    <input type="password" class="pass-key" required placeholder="Password" v-model="password">
                                                    <span class="showw">SHOW</span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="field space">
                                                        <span><v-icon>mdi-bank</v-icon></span>
                                                        <input type="text" required placeholder="Bank Name" v-model="title">
                                                    </div>
                                                    <div class="field space">
                                                        <span><v-icon>mdi-credit-card</v-icon></span>
                                                        <input type="number" required placeholder="IBAN Number" v-model="account">
                                                    </div>
                                                </div>
                                                <div class="field space">
                                                    <input type="submit" value="SIGNUP">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {mapActions} from "vuex";
    export default {
        name: "Signup",
        data() {
            return {

                firstName: "",
                lastName: "",
                email: "",
                password: "",
                success: "",
                error: "",
                title: "",
                account: "",
                company: "",
            }
        },
        computed: {
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

        methods: {
            ...mapActions(['registerUser', 'hideSnackbar']),
            async handleuserRegister() {
                    await this.registerUser({
                        firstname: this.firstName,
                        lastname: this.lastName,
                        email: this.email,
                        password: this.password
                    });

            },
            async handlecompanyRegister() {
                await this.registerUser({
                    firstname: this.firstName,
                    lastname: this.lastName,
                    email: this.email,
                    password: this.password,
                    companyname: this.company,
                    title: this.title,
                    accountnumber: this.account
                });
            },

        }
    }

</script>

<style scoped>
.signup {
    color: #fff;
    padding: 0 20px;
    text-transform: uppercase;
    font-weight: 700;
    font-size: clamp(13px, 3vw, 18px);
}
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');
.field {
    position: relative;
    height: 45px;
    width: 100%;
    display: flex;
    background: rgba(255, 255, 255, 0.94);
}

.field span {
    color: #222;
    width: 45px;
    line-height: 45px;
}

.field input {
    height: 100%;
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    color: #222;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
}

.space {
    margin-top: 16px;
}
/* Please ❤ this if you like it! */
.bg-img {
    background: url('/assets/banner.png');
    height: 100vh;
    background-size: cover;
    background-position: center;
}


.showw {
    position: absolute;
    right: 13px;
    font-size: 13px;
    font-weight: 700;
    color: #222;
    display: none;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
}

.pass-key:valid ~ .showw {
    display: block;
}



.pass a {
    color: white;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}

.pass:hover a {
    text-decoration: underline;
}

.field input[type="submit"] {
    background: #3498db;
    border: 1px solid #2691d9;
    color: white;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
}

.field input[type="submit"]:hover {
    background: #2691d9;
}


p {
    font-weight: 500;
    font-size: 14px;
    line-height: 1.7;
}
h4 {
    font-weight: 600;
}
h6 span{
    color: #fff;
    padding: 0 20px;
    text-transform: uppercase;
    font-weight: 700;
    font-size: clamp(13px, 3vw, 18px);
}
.section{
    position: relative;
    width: 100%;
    display: block;
}
.full-height{
    min-height: 100vh;
}
[type="checkbox"]:checked,
[type="checkbox"]:not(:checked){
    position: absolute;
    left: -9999px;
}
.checkbox:checked + label,
.checkbox:not(:checked) + label{
    position: relative;
    display: block;
    text-align: center;
    width: 60px;
    height: 16px;
    border-radius: 8px;
    padding: 0;
    margin: 10px auto;
    cursor: pointer;
    background-color: #fff;
}
.checkbox:checked + label:before,
.checkbox:not(:checked) + label:before{
    position: absolute;
    display: block;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #fff;
    background-color: #102770;
    font-family: 'unicons';
    content: '';
    z-index: 20;
    top: -10px;
    left: -10px;
    line-height: 36px;
    text-align: center;
    font-size: 24px;
    transition: all 0.5s ease;
    background: url('/assets/b1.png') no-repeat center;
}
.checkbox:checked + label:before {
    transform: translateX(44px) rotate(-360deg);
}


.card-3d-wrap {
    position: relative;
    width: 440px;
    max-width: 100%;
    height: 400px;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    perspective: 800px;
    margin-top: 60px;
}
.card-3d-wrapper {
    width: 100%;
    height: 100%;
    position:absolute;
    top: 0;
    left: 0;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    transition: all 600ms ease-out;
}
.card-front, .card-back {
    width: 100%;
    box-shadow: -1px 4px 28px 0px rgba(0,0,0,0.75);
    background-size: 300%;
    position: absolute;
    border-radius: 6px;
    left: 0;
    top: 0;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    height: 115%;
    background: url('/assets/banner.png') center no-repeat;
    transform-style: preserve-3d;
}
.card-back {
    transform: rotateY(180deg);
}
.checkbox:checked ~ .card-3d-wrap .card-3d-wrapper {
    transform: rotateY(180deg);
}
.center-wrap{
    position: absolute;
    width: 100%;
    padding: 0 35px;
    top: 50%;
    left: 0;
    transform: translate3d(0, -50%, 35px) perspective(100px);
    z-index: 20;
    display: block;
}

.form-group input:-ms-input-placeholder  {
    color: #c4c3ca;
    opacity: 0.7;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input::-moz-placeholder  {
    color: #c4c3ca;
    opacity: 0.7;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input:-moz-placeholder  {
    color: #c4c3ca;
    opacity: 0.7;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input::-webkit-input-placeholder  {
    color: #c4c3ca;
    opacity: 0.7;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input:focus:-ms-input-placeholder  {
    opacity: 0;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input:focus::-moz-placeholder  {
    opacity: 0;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input:focus:-moz-placeholder  {
    opacity: 0;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}
.form-group input:focus::-webkit-input-placeholder  {
    opacity: 0;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
}

</style>
