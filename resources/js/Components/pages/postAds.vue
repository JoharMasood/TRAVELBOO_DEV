<template>
    <div class="height">
        <div class="progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" :style="progressStyle"></div>
        </div>
        <div class=" ">
            <div class="container">
                <div class="word-container heading">
                    <h1 class="text_styling">{{ part }}</h1>
                </div>
                <form id="contactForm" class="form" @submit.prevent="handlesubmit" enctype="multipart/form-data">
                    <div class="step" v-show="currentStep === 'contact'">
                        <h3>Step 1: Add basic info</h3>

                        <label>Title:</label>
                        <input type="text" v-model="form.title" placeholder="Title" class="form-control" required>

                        <label>Price:</label>
                        <input type="number" v-model="form.price" placeholder="Price" class="form-control" required>

                        <label for="personCount">Person Count</label>
                        <input id="personCount" type="number" min="1" v-model="form.personCount" required
                               placeholder="Person"
                               class="form-control">
                        <label>Date:</label>
                        <div>
                            <input type="text" v-model="selectedDate" @focus="showDatePicker = true" @input="validateDate" @keydown.enter.prevent>
                            <div v-if="showDatePicker" class="date-picker">
                                <div class="calendar">
                                    <div class="header">
                                        <button type="button" @click="previousMonth">&lt;</button>                                        <span>{{ months[month] }} {{ year }}</span>
                                        <button type="button" @click="nextMonth">&gt;</button>
                                    </div>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th v-for="day in daysOfWeek" :key="day">{{ day }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="week in calendar" :key="week">
                                            <td v-for="date in week" :key="date" @click="selectDate(date)">{{
                                                    date
                                                }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="!isDateValid" class="error-message">Invalid date. Please enter a valid date in
                                the format DD-MM-YYYY.
                            </div>
                        </div>


                        <div class="d-flex justify-end">
                            <button type="button"
                                    class="btn btn-primary next-btn"
                                    @click="nextStep"
                                    :disabled="!isCurrentStepValid">Next
                            </button>
                        </div>
                        <div class="ad-note">
                            <p><strong>Important Notice:</strong></p>
                            <p>This advertisement is valid until the departure date mentioned. After the departure date,
                                the ad will no longer be visible.</p>
                            <p>Please make sure to take note of the departure date and make any necessary arrangements
                                or inquiries before that time.</p>
                            <p>If you have any questions or need further assistance, feel free to contact us.</p>
                        </div>
                    </div>

                    <div class="step" v-show="currentStep === 'tour'">
                        <h3>Step 2: Tour Details</h3>

                        <label>Days:</label>
                        <select v-model="form.days" class="form-control">
                            <option v-for="n in 15" :value="n">{{ n }}</option>
                        </select>

                        <label>Nights:</label>
                        <select v-model="form.nights" class="form-control">
                            <option v-for="n in Math.min(form.days, 15)" :value="n">{{ n }}</option>
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


                        <div class="d-flex justify-space-between">
                            <button type="button" class="btn btn-primary prev-btn" @click="prevStep">Previous</button>
                            <button type="button"
                                    class="btn btn-primary next-btn"
                                    @click="nextStep"
                                    :disabled="!isCurrentStepValid">Next
                            </button>
                        </div>
                    </div>

                    <div class="step" v-show="currentStep === 'additional'">
                        <h3>Step 3: Additional Information</h3>

                        <label>Description:</label>
                        <textarea v-model="form.description" placeholder="Write something" class="form-control"
                                  required></textarea>

                        <label>Image:</label>
                        <input type="file" name="image" accept="image/*" @change="onFileChange">
                        <div class="note">Accepted file types: JPEG, PNG, JPG, GIF, SVG (Max file size: 2MB)</div>

                        <div class="d-flex justify-space-between">
                            <button type="button" class="btn btn-primary prev-btn" @click="prevStep">Previous</button>
                            <button type="button"
                                    class="btn btn-primary next-btn"
                                    @click="nextStep"
                                    :disabled="!isCurrentStepValid">Next
                            </button>
                        </div>
                    </div>

                    <div class="step" v-show="currentStep === 'preview'">
                        <h3>Step 4: Preview</h3>

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
                        <div class="d-flex justify-space-between">
                            <button type="button" class="btn btn-primary prev-btn" @click="prevStep">Previous</button>
                            <button type="submit" class="btn btn-primary ml-3">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <Snackbar :message="message" v-if="message" :color="color"/>
</template>

<script>
import {mapActions} from "vuex";
import Snackbar from "./Snackbar";

export default {
    components: "Snackbar",
    data() {
        return {
            selectedDate: '',
            showDatePicker: false,
            currentDate: new Date(),
            daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            months: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            isDateValid: true,
            words: [
                'Post your ad ',
                'Work with us ',
                'Have fun ',
            ],
            part: '',
            i: 0,
            offset: 0,
            len: 0,
            forwards: true,
            skip_count: 0,
            skip_delay: 15,
            speed: 70,
            intervalId: null,
            currentStepIndex: 0,
            steps: ["contact", "tour", "additional", "preview"],
            form: {
                title: "",
                price: null,
                days: null,
                nights: null,
                personCount: null,
                meal: "",
                bonfire: "",
                tourGuide: "",
                image: "",
                description: "",
            },
            defaultImage: '/assets/d1.png',
        };
    },
    mounted() {
        this.len = this.words.length;
        this.intervalId = setInterval(this.wordflick, this.speed);
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
    },
    computed: {
        message() {
            return this.$store.getters.getmessage;
        },
        color() {
            return this.$store.getters.getcolor;
        },
        year() {
            return this.currentDate.getFullYear();
        },
        month() {
            return this.currentDate.getMonth();
        },
        calendar() {
            const firstDay = new Date(this.year, this.month, 1).getDay();
            const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            const calendar = [];
            let date = 1;

            for (let week = 0; week < 6; week++) {
                const days = [];

                for (let day = 0; day < 7; day++) {
                    if ((week === 0 && day < firstDay) || date > daysInMonth) {
                        days.push('');
                    } else {
                        days.push(date);
                        date++;
                    }
                }

                calendar.push(days);

                if (date > daysInMonth) {
                    break;
                }
            }

            return calendar;
        },
        isCurrentStepValid() {
            return this.validateStep();
        },
        progressStyle() {
            return `width: ${(this.currentStepIndex + 1) / this.steps.length * 100}%`;
        },
        currentStep() {
            return this.steps[this.currentStepIndex];
        },
        imageSrc() {
            return this.form.image ? URL.createObjectURL(this.form.image) : this.defaultImage;
        },
    },

    methods: {
        selectDate(date) {
            const selectedDate = new Date(this.year, this.month, date);
            const currentDate = new Date();

            if (selectedDate > currentDate) {
                const formattedDate = `${date.toString().padStart(2, '0')}-${(this.month + 1).toString().padStart(2, '0')}-${this.year}`;
                this.selectedDate = formattedDate;
                this.showDatePicker = false; // Close the calendar after selecting a date
                this.isDateValid = true; // Reset the validation status
            }
        },
        previousMonth() {
            this.currentDate = new Date(this.year, this.month - 1);
        },
        nextMonth() {
            this.currentDate = new Date(this.year, this.month + 1);
        },
        validateDate() {
            const regex = /^\d{2}-\d{2}-\d{4}$/;
            this.isDateValid = regex.test(this.selectedDate);
        },

        validateStep() {
            if (this.currentStep === 'contact') {
                return this.form.title && this.form.price && this.form.personCount;
            } else if (this.currentStep === 'tour') {
                return this.form.days && this.form.nights && this.form.meal && this.form.bonfire && this.form.tourGuide;
            } else if (this.currentStep === 'additional') {
                return this.form.description;

            } else if (this.currentStep === 'preview') {
                return true; // No specific validation for preview step
            }
        },

        wordflick() {
            if (this.forwards) {
                if (this.offset >= this.words[this.i].length) {
                    this.skip_count++;
                    if (this.skip_count === this.skip_delay) {
                        this.forwards = false;
                        this.skip_count = 0;
                    }
                }
            } else {
                if (this.offset === 0) {
                    this.forwards = true;
                    this.i++;
                    this.offset = 0;
                    if (this.i >= this.len) {
                        this.i = 0;
                    }
                }
            }
            this.part = this.words[this.i].substr(0, this.offset);
            if (this.skip_count === 0) {
                if (this.forwards) {
                    this.offset++;
                } else {
                    this.offset--;
                }
            }
        },
        nextStep() {
            if (this.currentStepIndex < this.steps.length - 1 && this.isCurrentStepValid) {
                this.currentStepIndex++;
            }

        },
        prevStep() {
            if (this.currentStepIndex > 0) {
                this.currentStepIndex--;
            }
        },
        ...mapActions(['postdata']),
        async handlesubmit(e) {
            e.preventDefault();

            try {
                const formData = new FormData();
                formData.append('place', this.form.title);
                formData.append('price', this.form.price);
                formData.append('days', this.form.days);
                formData.append('night', this.form.nights);
                formData.append('meal', this.form.meal);
                formData.append('bonfire', this.form.bonfire);
                formData.append('description', this.form.description);
                formData.append('person', this.form.personCount);
                formData.append('image', this.form.image);
                formData.append('tourguide', this.form.tourGuide);
                formData.append('validationdate', this.selectedDate);
                console.log(formData)
                await this.postdata(formData);
            } catch (error) {
                console.error('Cannot post ad', error);
            }
        },
        onFileChange(e) {
            console.log(e);

            this.form.image = e.target.files[0] ? e.target.files[0] : null;
        },
    },
    destroyed() {
        // revoke the URL created by URL.createObjectURL
        if (this.form.image) {
            URL.revokeObjectURL(this.imageSrc);
        }
    },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&family=Indie+Flower&display=swap');

.note {
    font-size: 14px;
    color: #777;
    margin-top: 5px;
    margin-bottom: 5px;
    text-align: center;
}

.height {
    min-height: 100vh;
}

.ad-note {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    padding: 10px;
    margin-top: 20px;
    font-size: 14px;
}

.ad-note p {
    margin: 0 0 10px;
}

.ad-note strong {
    font-weight: bold;
}

.date-picker {
    position: absolute;
    z-index: 1;
}

.calendar {
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    display: inline-block;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

table {
    width: 100%;
}

th,
td {
    text-align: center;
    padding: 5px;
    cursor: pointer;
}

th {
    text-transform: uppercase;
}

td:hover {
    background-color: #eee;
}

.error-message {
    color: red;
    margin-top: 5px;
}

.word-container {
    height: 3em; /* Set a fixed height */
    overflow: hidden; /* Hide overflow */
    margin: auto;
}

.text_styling {
    font-family: 'IBM Plex Mono', monospace;
    font-weight: bolder;
    text-align: center;
}

.is-invalid {
    border-color: red;
}

.heading {
    margin: 100px 0px;
}

.container {
    margin-top: 20px;
}

.step.show {
    display: block;
}

.progress {
    margin-bottom: 20px;
    border-radius: 0px;
    height: 0.5rem;
}

.progress-bar {
    background-color: #212121;
}

.progress-bar-striped {
    background-image: none;
}

.form {
    width: 100%;
    max-width: 100%;
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
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 40px 0px;
    width: 100% !important;
    /*max-width: 500px;*/
    /*display: flex;*/
    /*align-items: center;*/
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

    /*.form {*/
    /*    width: 100%;*/
    /*}*/
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
</style>
