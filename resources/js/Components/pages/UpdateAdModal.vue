<template>


    <!-- Modal -->
    <div :class="show?'show modal fade':'modal fade'" id="exampleModal" tabindex="-1" :style="show?'display:block':''"
         aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5 " id="exampleModalLabel">UPDATE YOUR AD</h1>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <form class="form"  enctype="multipart/form-data">
                                <label>Title:</label>
                                <input type="text" v-model="form.title" placeholder="Title" class="form-control">

                                <label>Price:</label>
                                <input type="number" v-model="form.price" placeholder="Price" class="form-control">

                                <label for="personCount">Person Count</label>
                                <input id="personCount" type="number" min="1" v-model="form.personCount" required
                                       placeholder="Person" class="form-control">

                                <div class="form-group">
                                    <label>Days:</label>
                                    <select v-model="form.days" class="form-control">
                                        <option v-for="n in 15" :value="n">{{ n }}</option>
                                    </select>
                                </div>

                                <label>Nights:</label>
                                <select v-model="form.nights" class="form-control">
                                    <option v-for="n in 15" :value="n">{{ n }}</option>
                                </select>

                                <label for="meal">Meal</label>
                                <select id="meal" v-model="form.meal" required class="form-control">
                                    <option value="">Select Meal option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <label for="bonfire">Bonfire</label>
                                <select id="bonfire" v-model="form.bonfire" required class="form-control">
                                    <option value="">Select Bonfire option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <label for="tourGuide">Tour Guide</label>
                                <select id="tourGuide" v-model="form.tourGuide" required class="form-control">
                                    <option value="">Select Tour guide option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <label>Description:</label>
                                <textarea v-model="form.description" placeholder="Write something"
                                          class="form-control"></textarea>

                                <label>Image:</label>
                                <input type="file" name="image" accept="image/*" @change="onFileChange">

                            </form>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="preview">
                                <div class="card">
                                    <img :src="imageSrc" alt="Tour Image">
                                    <h5>Trip to {{ form.title }}</h5>
                                    <h5>Price: Rs.{{ form.price }}</h5>
                                    <div class="details">
                                        <div>
                                            <p>Days: {{ form.days }}</p>
                                        </div>
                                        <div>
                                            <p>Nights: {{ form.nights }}</p>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div>
                                            <p>Person Count: {{ form.personCount }}</p>

                                        </div>
                                        <div>
                                            <p>Meal: {{ form.meal }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update(form.id)" >Save changes</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import {mapActions, mapState} from "vuex";

    export default {

        name: "UpdateAdModal",
        props: ['show', 'trip'],
        data() {
            return {
                form: {
                    id: "",
                    title: "",
                    price: null,
                    days: null,
                    nights: null,
                    personCount: null,
                    meal: "",
                    bonfire: "",
                    tourGuide: "",
                    description: "",
                    image: null,
                },
                defaultImage: '/assets/d1.png',
            }
        },
        computed: {
            imageSrc() {
                if (this.form.image) {
                    if (typeof this.form.image === 'string') {
                        // If it is a URL, return it directly
                        return this.form.image;
                    } else {
                        // If it is a File object, create a temporary URL
                        return URL.createObjectURL(this.form.image);
                    }
                } else {
                    // If no image is present, return the default image
                    return this.defaultImage;
                }
            }
        },



        mounted() {
            this.form.id = this.trip.id;
            this.form.title = this.trip.place;
            this.form.price = this.trip.price;
            this.form.days = this.trip.days;
            this.form.nights = this.trip.night;
            this.form.personCount = this.trip.person;
            this.form.meal = this.trip.meal;
            this.form.bonfire = this.trip.bonfire;
            this.form.tourGuide = this.trip.tourguide;
            this.form.description = this.trip.description;
            this.form.image = this.trip.image;
        },

        methods: {
            ...mapActions(['updateAd']),
            ...mapState(['updateAdMessage']),
            onFileChange(e) {
                console.log(e);

                this.form.image = e.target.files[0] ? e.target.files[0] : null;
            },
            async update(id){
                    let bb = new FormData();
                bb.append('place', this.form.title);
                bb.append('price', this.form.price);
                bb.append('days', this.form.days);
                    bb.append('night', this.form.nights);
                    bb.append('meal', this.form.meal);
                    bb.append('bonfire', this.form.bonfire);
                    bb.append('description', this.form.description);
                    bb.append('person', this.form.personCount);
                    bb.append('image', this.form.image);
                    bb.append('tourguide', this.form.tourGuide);
                    await this.updateAd({id:id, bb:bb}).then(()=>{
                        this.$emit('close')
                    });

                // try {
                // } catch (e) {
                //     console.error('Cannot Update ad', e);
                // }
            },
            close() {
                this.$emit('close')
            },
        }
    };
</script>

<style scoped>


    .form {
        width: 100% !important;
    }

    .form label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .form input,
    .form select,
    .form textarea {
        display: block;
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .form button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        cursor: pointer;
    }

    .preview {
        width: 100% !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .card {
        background-color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        max-width: 500px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        /*align-items: center;*/
        gap: 0.5rem;
    }

    .card img {
        border-top-left-radius: var(--bs-card-inner-border-radius);
        border-top-right-radius: var(--bs-card-inner-border-radius);
        max-width: 100%;
        height: 260px;
        width: 260px;
    }

    .card h1 {
        font-size: 2rem;
        margin-top: 1rem;
        margin-bottom: 0;
    }

    .card p {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    @media (min-width: 768px) {
        .container {
            flex-direction: row;
        }

        .form {
            width: 50%;
        }

        .preview {
            width: 50%;
        }
    }

    select {
        display: block;
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .details {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    @media (max-width: 991px) {
        .row {
            display: flex;
            flex-direction: column-reverse;
        }
    }

    @media (max-width: 991px) {
        .preview {
            padding-bottom: 35px;
        }
    }
</style>

