<template>
    <div class="section-users">
        <h3 class="text-center mb-5" style="background-color: dimgrey;
    padding: 20px 0px;
    color: #fff;">Usage Data</h3>

            <div class="container section">
                <div class="chart-container">
                    <div ref="chartContainer"></div>
                </div>
                <div class="options-container">
                    <select class="form-select" v-model="selectedOption" @change="fetchData">
                        <option value="last_7_days">Last 7 Days</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="last_1_year">Last 1 Year</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="section-users">
        <h3 class="text-center mb-10" style="background-color: dimgrey;
    padding: 20px 0px;
    color: #fff;">Users Data</h3>
        <div class="container">
            <div class="scrollable-div">
                <div
                    class="hvr-sweep-to-right mb-10 d-flex flex-column flex-sm-row align-items-center"
                    v-for="(user, index) in getUsers"
                    :key="index"
                    @click="openModal(user.id)"
                >
                    <div class="flex-fill">
                        <img :src="user.image || defaultimage" alt="" class="avatar" />
                    </div>
                    <div class="flex-fill">
                        <span class="email mr-5">Email: {{ user.email }}</span>
                    </div>
                    <div class="flex-fill">
        <span class="username mr-5"
        >Name: {{ getFullName(user.firstname, user.lastname) }}</span
        >
                    </div>
                    <div class="flex-fill">
        <span class="created-at"
        >Created at: {{ formattedCreatedAt(user.created_at) }}</span
        >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AdminPanelConfirmDeleteModal :show="showModal" :data="selectedUserId" @close="closeModal"/>
    <div class="modal-backdrop fade show" v-if="showModal"></div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import Highcharts from 'highcharts';
import accessibility from 'highcharts/modules/accessibility';
import AdminPanelConfirmDeleteModal from "./AdminPanelConfirmDeleteModal";

accessibility(Highcharts); // Enable the accessibility module

export default {
    name: 'AdminPanel',
    components: [AdminPanelConfirmDeleteModal],
    data() {
        return {
            selectedOption: 'last_7_days',
            showModal: false,
            selectedUserId: null,
            defaultimage: '/assets/default.png'
        };
    },
    computed: {
        ...mapState(['usageData']),
        ...mapGetters(['getUsers']),
    },
    mounted() {
        this.fetchUsers();
        this.fetchData();
    },
    methods: {
        formattedCreatedAt(createdAt) {
            if (createdAt) {
                const createdDate = new Date(createdAt);
                const day = createdDate.getDate().toString().padStart(2, '0');
                const month = (createdDate.getMonth() + 1).toString().padStart(2, '0');
                const year = createdDate.getFullYear().toString();

                return `${day}-${month}-${year}`;
            }

            return '';
        },
        ...mapActions(['fetchUsageData', 'fetchUsers']),
        getFullName(firstName, lastName) {
            const capitalizedFirstName =
                firstName.charAt(0).toUpperCase() + firstName.slice(1);
            const capitalizedLastName =
                lastName.charAt(0).toUpperCase() + lastName.slice(1);
            return `${capitalizedFirstName} ${capitalizedLastName}`;
        },
        fetchData() {
            this.fetchUsageData(this.selectedOption)
                .then(() => {
                    this.renderChart();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        renderChart() {
            Highcharts.chart(this.$refs.chartContainer, {
                chart: {
                    type: 'line',
                },
                title: {
                    text: 'Usage Data',
                },
                xAxis: {
                    categories: this.usageData.map((data) => data.date),
                },
                yAxis: {
                    title: {
                        text: 'Usage (hh:mm)', // Adjust yAxis label
                    },
                    labels: {
                        formatter: function () {
                            const hours = Math.floor(this.value);
                            const minutes = Math.round((this.value - hours) * 60);
                            return (
                                hours.toString().padStart(2, '0') +
                                ':' +
                                minutes.toString().padStart(2, '0')
                            );
                        },
                    },
                },
                series: [
                    {
                        name: 'Usage',
                        data: this.usageData.map((data) => data.usage),
                    },
                ],
                accessibility: {
                    enabled: false, // Disable accessibility warning
                },
            });
        },
        openModal(userId) {
            this.selectedUserId = userId;
            this.showModal = true;
        },
        closeModal() {
            this.selectedUserId = null;
            this.showModal = false;
        },
        // confirmDeleteUser() {
        //     // Handle delete logic for the selected user
        //     console.log('Deleting user with ID:', this.selectedUserId);
        //     this.closeModal();
        // },
    },
};
</script>

<style scoped>
.scrollable-div {
    min-height: 500px; /* Set the desired height for the scrollable div */
    overflow-y: auto; /* Enable vertical scrolling */
    /* Additional styles as needed */
}

.section {
    margin-top: 120px;
}


.options-container {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}

/* Sweep To Right */
.hvr-sweep-to-right {
    padding: 30px;
    background: lightgrey;
    display: inline-block;
    transform: perspective(1px) translateZ(0);
    position: relative;
    transition: color 0.3s;
    border-radius: 10px;
    width: 100%;
    cursor: pointer;
}

.hvr-sweep-to-right:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    background: #2098d1;
    transform: scaleX(0);
    transform-origin: 0 50%;
    transition: transform 0.3s ease-out;
    border-radius: 10px;
}

.hvr-sweep-to-right:hover {
    color: white;
    border-radius: 10px;
}

.hvr-sweep-to-right:hover:before {
    transform: scaleX(1);
}

.avatar {
    height: 70px;
    border-radius: 50%;
    margin-right: 10px;
}

@media (max-width: 767px) {
    .hvr-sweep-to-right {
        padding: 10px;
        width: 100%;
    }

    .avatar {
        height: 50px;
        margin-right: 5px;
    }

    .content {
        margin-left: 5px;
    }
}

/* Add your custom styles here */
</style>
