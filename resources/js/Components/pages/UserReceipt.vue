<template>
    <div class="height">
    <div class="receipt container" ref="receiptContent">
        <!-- Receipt content goes here -->
        <h1 class="heading">TRAVELBOO CUSTOMER RECEIPT</h1>
        <p class="font-weight-bold">Printing Date & Time: <span id="currentDateTime"></span></p>
        <p>Name: {{ capitalizeFirstLetter(response.firstname) }} {{ capitalizeFirstLetter(response.lastname) }}</p>
        <p>Trip to: {{ response.title }}</p>
        <p>Email: {{ response.email }}</p>
        <p>Amount: Rs. {{ response.price }}</p>
        <table style="width:100%" class="text-center">
            <tr>
                <th>Package Information</th>
                <th>Detail</th>
            </tr>
            <tr>
                <td>Person</td>
                <td>{{response.personCount}}</td>
            </tr>
            <tr>
                <td>Days</td>
                <td>{{response.days}}</td>
            </tr>
            <tr>
                <td>Nights</td>
                <td>{{response.nights}}</td>
            </tr>
            <tr>
                <td>Meal</td>
                <td>{{capitalizeFirstLetter(response.meal)}}</td>
            </tr>
            <tr>
                <td>Bonfire</td>
                <td>{{capitalizeFirstLetter(response.bonfire)}}</td>
            </tr>
            <tr>
                <td>Tourguide</td>
                <td>{{capitalizeFirstLetter(response.tourGuide)}}</td>
            </tr>

            <tr>
                <td>Validation Date</td>
                <td>{{response.validationdate}}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{response.description}}</td>
            </tr>
        </table>
        <div class="note-container">
            <p class="note">
                <strong>Important Notice:</strong> This receipt serves as proof of your reservation. Please note that this receipt is only valid until the departure date of the trip. It is essential to redeem this receipt and complete the necessary formalities before the specified departure date. Failure to do so may result in the cancellation of your reservation.
            </p>
            <p class="note">
                Kindly review the terms and conditions associated with your booking. By proceeding with this reservation, you acknowledge and agree to abide by all terms and conditions specified by Travelboo. Should you have any questions or concerns, please reach out to our customer support team for assistance.
            </p>
        </div>
    </div>
        <div class="container">
            <button v-if="!isDownloading" class="btn btn-dark mt-5" @click="downloadReceipt">Download Receipt</button>
        </div>
    </div>

</template>

<script>
    import html2pdf from "html2pdf.js";
    import { mapGetters } from "vuex";

    export default {
        name: "UserReceipt",
        data() {
            return {
                isDownloading: false
            };
        },
        computed: {
            ...mapGetters(["getreceiptresponse"]),
            response() {
                const response = this.getreceiptresponse;
                const previouspath = this.$router.options.history.state.back;
                if (!response && previouspath === '/Destination') {
                    this.$router.push("/Destination");
                } else if (!response && previouspath === '/purchased-ads'){
                    this.$router.push("/purchased-ads");
                }

                return response;
            },
            capitalizeFirstLetter() {
                return (value) => {
                    if (!value) return "";
                    return value.charAt(0).toUpperCase() + value.slice(1);
                };
            },
        },
        methods: {
            downloadReceipt() {
                this.isDownloading = true;
                const receiptContent = this.$refs.receiptContent;

                // Hide the button during PDF conversion
                const downloadButton = document.querySelector("button");
                downloadButton.style.display = "none";

                html2pdf()
                    .set({
                        margin: [10, 10, 10, 10],
                        filename: "receipt.pdf",
                        image: { type: "jpeg", quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
                    })
                    .from(receiptContent)
                    .save()
                    .then(() => {
                        // Show the button after PDF conversion
                        downloadButton.style.display = "block";
                        this.isDownloading = false;
                    })
                    .catch((error) => {
                        console.error("Error while generating PDF:", error);
                        this.isDownloading = false;
                    });
            },
        },
        mounted() {
            const currentDate = new Date();

            // Format the date and time as a string
            const formattedDateTime = currentDate.toLocaleString();

            // Update the HTML content
            document.getElementById("currentDateTime").textContent = formattedDateTime;
        },
    };
</script>

<style scoped>
    .height{
        min-height: 100vh;

    }
    .heading {
        text-align: center;
        margin: 50px 0px;
    }
.receipt{
    display: flex;
    flex-direction: column;
}
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .note-container {
        text-align: justify;
        margin-top: 20px;
    }

    .note {
        margin-bottom: 10px;
        font-style: italic;
        color: gray;
    }
</style>
