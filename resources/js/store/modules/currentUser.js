import axios from 'axios';
import Vuex from "vuex";
import Home from "../../Components/pages/Home";
import {navigateTo} from '../../Routes/routes';

const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/',
    headers: {
        'Content-Type': 'application/json',
    },
});
instance.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response && error.response.status === 403) {
        store.commit('SET_MESSAGE_RESPONSE', "Your session is expired!")
        store.commit('SET_MESSAGE_COLOR', "danger")
        localStorage.removeItem('token');
        store.commit('CLEAR_AUTH_STATE')
        setTimeout(() => {
            store.commit('SET_MESSAGE_RESPONSE', "")
            store.commit('SET_MESSAGE_COLOR', "");
            window.location.href = "/#/Home";
        }, 1500)
    }
    return Promise.reject(error);
});
instance.interceptors.request.use( config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

const store = new Vuex.Store({
    namespaced: true,
    state: {
        randomReviews: [],
        users: [],
        token: localStorage.getItem('token'),
        selectedOption: 'last_7_days',
        usageData: [],
        allusersdata: {
            // ads: "", // Initial state for all ads
        },
        // allusersdata: [],
        authuserdata: [],
        signupmessage: null,
        signuperror: null,
        postad: [],
        ads: [],
        updateAdMessage: '',
        registrationResponse: '',
        userinfo: '',
        PurchaseResponse: '',
        ReceiptResponse: '',
        showButton: false,
        UserPurchasedAds: '',
        ReviewsResponse: '',
        ShowReviews: null,
        reviews: [],
        contacts: [],
        message: '',
        color: '',
        purchasedAds: '',
        refundedads: "",
        getrefundedads: "",
    },
    getters: {
        getrefundedadsadminpanel: state => state.getrefundedads,
        getrefundedads: state => state.refundedads,
        getmessage: state => state.message,
        getRandomReviews: state => state.randomReviews,
        allReviews: state => state.reviews,
        getUsers: state => state.users,
        getcolor: state => state.color,
        isAuthenticated: state => state.token,
        getUpdateAdMessage(state) {
            return state.updateAdMessage;
        },
        getAuthdata(state) {
            return state.authuserdata;
        },
        getregistrationResponse(state) {
            return state.registrationResponse
        },
        getuserinfo(state) {
            return state.userinfo;
        },
        getpurchaseresponse(state) {
            return state.PurchaseResponse
        },
        getreceiptresponse(state) {
            return state.ReceiptResponse
        },
        getshowbuttonresponse(state) {
            return state.showButton
        },
        getuserpurchasedads(state) {
            return state.UserPurchasedAds
        },
        getreviewresponse(state) {
            return state.ReviewsResponse;
        },
        getreviews(state) {
            return state.ShowReviews;
        },
        filteredAds: (state) => state.allusersdata,
    },
    mutations: {
        markAdAsPurchased(state, adId) {
            state.purchasedAds = adId;
        },
        setRandomReviews: (state, reviews) => {
            state.randomReviews = reviews;
        },
        SET_REVIEWS(state, reviews) {
            state.reviews = reviews;
        },
        DELETE_REVIEW(state, reviewId) {
            state.reviews = state.reviews.filter(review => review.review_id !== reviewId);
        },
        deleteUser(state, userId) {
            const index = state.users.findIndex(user => user.id === userId);
            if (index !== -1) {
                state.users.splice(index, 1);
            }
        },
        setSelectedOption(state, option) {
            state.selectedOption = option;
        },
        setUsageData(state, data) {
            state.usageData = data;
        },
        SET_RECEIPT_RESPONSE(state, message) {
            state.ReceiptResponse = message
        },
        setupdateAd(state, message) {

            state.updateAdMessage = message;
        },
        setToken(state, token) {
            state.token = token;
            localStorage.setItem('token', token);
            instance.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },
        setAllUsersData(state, data) {
            state.allusersdata = data;
        },
        setAuthUserData(state, authdata) {

            state.authuserdata = authdata;
        },
        SET_MESSAGE(state, message) {
            state.signupmessage = message
        },
        SET_ERROR(state, error) {
            state.signuperror = error
        },
        SET_RESPONSE(state, postad) {
            state.postad = postad
        },
        DELETE_AD(state, id) {
            const index = state.ads.findIndex(ad => ad.id === id);
            if (index !== -1) {
                state.ads.splice(index, 1);
            }

            // Update authuserdata if the deleted ad matches
            state.authuserdata = state.authuserdata.filter(ad => ad.id !== id);
        },
        SET_INFO_RESPONSE(state, info) {
            state.userinfo = info;
        },
        SET_PURCHASE_RESPONSE(state, response) {
            state.PurchaseResponse = response
        },
        SET_BUTTON_VISIBILITY(state, value) {
            state.showButton = value; // Update the button visibility
        },
        SET_USER_PURCHASEDADS(state, ads) {
            state.UserPurchasedAds = ads
        },
        SET_REVIEW_RESPONSE(state, review) {
            state.ReviewsResponse = review;
        },
        SET_RATINGS_AND_COMMENTS(state, payload) {
            state.ShowReviews = payload;
        },
        SET_USERS(state, users) {
            state.users = users;
        },
        SET_CONTACTS(state, contacts) {
            state.contacts = contacts;
        },
        SET_MESSAGE_RESPONSE(state, message) {
            state.message = message
        },
        SET_MESSAGE_COLOR(state, color) {
            state.color = color
        },
        CLEAR_AUTH_STATE(state) {
            state.token = false;
        },
        SET_USER_REFUNDEDADS(state, refundedads) {
          state.refundedads = refundedads;
        },
        removePurchasedAd: (state, { userId, adId }) => {
            const userIndex = state.allusersdata.findIndex((user) => user.user_id === userId);
            if (userIndex !== -1) {
                const user = state.allusersdata[userIndex];
                const adIndex = user.ads.findIndex((ad) => ad.id === adId);
                if (adIndex !== -1) {
                    user.ads.splice(adIndex, 1);
                    if (user.ads.length === 0) {
                        state.allusersdata.splice(userIndex, 1);
                    }
                }
            }
        },
        GET_REFUND_REQUEST(state, info) {
            state.getrefundedads = info;
        }
    },
    actions: {
        async refundPayment({ commit }, adId) {
            try {
                const response = await instance.post(`refund-payment?ad_id=${adId}`);
                // Handle the response if needed
                commit('SET_MESSAGE_RESPONSE', response.data.message);
                commit('SET_MESSAGE_COLOR', 'success');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            } catch (error) {
                // Handle any errors
                console.error(error);
                commit('SET_MESSAGE_RESPONSE', error.message);
                commit('SET_MESSAGE_COLOR', 'danger');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            }
        },
        async fetchRefundRequests({ commit }) {
            try {
                const response = await instance.get('/refund-requests');
                commit('GET_REFUND_REQUEST', response.data);
            } catch (error) {
                console.error(error);

            }
        },
        async createRefundRequest({ commit }, requestData) {
            try {
                const response = await instance.post('/refund-requests', requestData);
                commit('SET_MESSAGE_RESPONSE', response.data.message);
                commit('SET_MESSAGE_COLOR', 'success');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            } catch (error) {
                console.error(error);
                commit('SET_MESSAGE_RESPONSE', error.message);
                commit('SET_MESSAGE_COLOR', 'danger');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            }
        },
        async checkAuth() {
            await instance.get('/check-auth')
        },
        removePurchasedAd({ commit, state }, { userId, adId }) {

            const userIndex = state.allusersdata.findIndex((user) => user.user_id === userId);

            if (userIndex !== -1) {
                const ads = state.allusersdata[userIndex].ads;
                const adIndex = ads.findIndex((ad) => ad.id === adId);
                if (adIndex !== -1) {
                    ads.splice(adIndex, 1);
                    if (ads.length === 0) {
                        state.allusersdata.splice(userIndex, 1);
                    }
                    commit('removePurchasedAd', { userId, adId });
                }
            }
        },
        async fetchContacts({commit}, dateRange) {
            try {
                let url = '/show-contact';
                if (dateRange) {
                    url += `?date_range=${dateRange}`;
                }
                console.log(url)
                const response = await instance.get(url);
                const contacts = response.data;
                commit('SET_CONTACTS', contacts);
            } catch (error) {
                console.error(error);
            }
        },
        async fetchReviews({commit}, params) {
            try {
                const queryParams = new URLSearchParams();

                if (params.query) {
                    queryParams.append('query', params.query);
                }
                const url = `admin-panel/reviews/?${queryParams.toString()}`;
                // const url = query ? `admin-panel/reviews/${encodeURIComponent(query)}` : 'admin-panel/reviews';
                console.log(url)
                const response = await instance.get(url);
                const reviews = response.data;
                commit('SET_REVIEWS', reviews);
            } catch (error) {
                console.error(error);
            }
        },
        async deleteReview({commit}, reviewInfo) {
            try {
                console.log(reviewInfo)
                const response = await instance.delete('/reviews', {
                    data: reviewInfo
                });
                const message = response.data.message;
                if (message === 'Review deleted successfully') {
                    commit('DELETE_REVIEW', reviewInfo.id);
                }
            } catch (error) {
                console.error(error);
            }
        },
        async submitReview({commit}, reviewData) {
            try {
                const response = await instance.post('/submitreview', reviewData);
                const review = response.data.message;

                // Commit the review to the state
                commit('SET_MESSAGE_RESPONSE', review);
                commit('SET_MESSAGE_COLOR', 'success');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            } catch (error) {
                commit('SET_MESSAGE_RESPONSE', error.message);
                commit('SET_MESSAGE_COLOR', 'danger');
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
                console.error(error);
                throw error;
            }
        },
        async userinfo({commit}) {
                const response = await instance.get('detail');
                const userData = response.data;
                commit('SET_INFO_RESPONSE', userData);
        },
        async updateProfilePic({commit}, image) {
            try {
                const response = await instance.post('/update-image', {image: image});
                const updatedProfilePic = response.data.message;
                commit('SET_MESSAGE_RESPONSE', updatedProfilePic);
                commit('SET_MESSAGE_COLOR', "success");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
                return true;
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async updateAd({commit, state}, data) {
            console.log(data);
            const response = await instance.post(`/ads/${data.id}`, data.bb, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            });
            const index = state.authuserdata.findIndex(ad => ad.id == data.id);
            if (index !== -1) {
                const updatedAuthUserData = [...state.authuserdata]; // Create a new array
                updatedAuthUserData[index] = response.data.ad; // Assign the updated ad to the corresponding index
                commit('setAuthUserData', updatedAuthUserData);
                commit('SET_MESSAGE_RESPONSE', response.data.message);
                commit('SET_MESSAGE_COLOR', "success");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            } else {
                commit('SET_MESSAGE_RESPONSE', "Ad not found.");
                commit('SET_MESSAGE_COLOR', "danger");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            }
            return true;
        },
        async deleteAd({commit, state}, id) {
            try {
                const response = await instance.delete(`/delete-post/${id}`);
                commit('DELETE_AD', id);
                commit('SET_MESSAGE_RESPONSE', response.data.message)
                commit('SET_MESSAGE_COLOR', "success")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async login({commit}, credentials) {
            // try {
            await instance.post('auth/login', credentials)
                .then(response => {
                    const token = response.data.access_token;
                    commit('setToken', token);
                    // commit('SET_MESSAGE_RESPONSE', "Logged In Successfully!");
                    // commit('SET_MESSAGE_COLOR', "success");
                    // setTimeout(() => {
                    //     commit('SET_MESSAGE_RESPONSE', "")
                    //     commit('SET_MESSAGE_COLOR', "");
                    // }, 3000)
                    // setTimeout(() => {
                        navigateTo('Home');
                    // }, 1000)
                }).catch((error) => {
                    commit('SET_MESSAGE_RESPONSE', "Invalid email or password");
                    commit('SET_MESSAGE_COLOR', "danger");
                    setTimeout(() => {
                        commit('SET_MESSAGE_RESPONSE', "")
                        commit('SET_MESSAGE_COLOR', "");
                    }, 3000)
                    console.error(error);
                    throw error;
                })
        },
        async postdata({commit, state}, credential) {
            await instance.post('ads', credential, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then((response) => {
                    const result = response.data.message;
                    commit('SET_MESSAGE_RESPONSE', result);
                    commit('SET_MESSAGE_COLOR', "success");
                    setTimeout(() => {
                        commit('SET_MESSAGE_RESPONSE', "")
                        commit('SET_MESSAGE_COLOR', "");
                    }, 3000)
                }).catch((e) => {
                    commit('SET_MESSAGE_RESPONSE', e);
                    commit('SET_MESSAGE_COLOR', "danger");
                    setTimeout(() => {
                        commit('SET_MESSAGE_RESPONSE', "")
                        commit('SET_MESSAGE_COLOR', "");
                    }, 3000)
                });
        },
        async logout({commit}) {
            try {
                const response = await instance.post('auth/logout')
                localStorage.removeItem('token')
                commit('CLEAR_AUTH_STATE')
                commit('SET_MESSAGE_RESPONSE', response.data.message);
                commit('SET_MESSAGE_COLOR', "success");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
                setTimeout(() => {
                    navigateTo('Home');
                }, 500)
                // Additional code after removing the token
            } catch (error) {
                commit('SET_MESSAGE_RESPONSE', error);
                commit('SET_MESSAGE_COLOR', "danger");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "");
                }, 3000)
                console.error(error);
                throw error;
            }

        },
        async fetchData({commit}, params = {}) {
            try {
                console.log(params);
                const queryParams = new URLSearchParams();

                if (params.query) {
                    queryParams.append('query', params.query);
                }

                if (params.sortOrder) {
                    queryParams.append('sort_order', params.sortOrder);
                }

                if (params.minPrice) {
                    queryParams.append('min_price', params.minPrice);
                }

                if (params.maxPrice) {
                    queryParams.append('max_price', params.maxPrice);
                }

                const url = `/filterAndSortAds?${queryParams.toString()}`;
                const response = await instance.get(url);
                const ads = response.data;
                commit('setAllUsersData', ads);
            } catch (error) {
                console.error('Error fetching ads:', error);
            }
        },
        async authdata({commit}, searchTerm) {
            try {
                console.log(searchTerm)
                await instance.get('myads',{ params: { search: searchTerm } }).then((response) => {
                    const authdata = response.data;
                    commit('setAuthUserData', authdata);
                    console.log(authdata);
                });
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async registerUser({commit}, credentials) {
            try {
                const response = await instance.post('register', credentials);
                const userData = response.data.message;
                commit('SET_MESSAGE_RESPONSE', userData);
                commit('SET_MESSAGE_COLOR', "success")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
            } catch (error) {
                commit('SET_MESSAGE_RESPONSE', error.response.data.message)
                commit('SET_MESSAGE_COLOR', "danger");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
                console.error(error);
                throw error;
            }
        },
        async postcontactDetails({commit}, credentials) {
            try {
                const response = await instance.post('post-contact', credentials);
                const userData = response.data.message;
                commit('SET_MESSAGE_RESPONSE', userData);
                commit('SET_MESSAGE_COLOR', "success")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
            } catch (error) {
                commit('SET_MESSAGE_RESPONSE', error.response.data.message);
                commit('SET_MESSAGE_COLOR', "danger")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
                console.error(error);
                throw error;
            }
        },
        async processpayment({commit}, credentials) {
            try {
                const response = await instance.post('process-payment', credentials);
                const userData = response.data.message;
                commit('SET_MESSAGE_RESPONSE', userData);
                commit('SET_MESSAGE_COLOR', "success")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
            } catch (error) {
                commit('SET_MESSAGE_RESPONSE', error.response.data.message);
                commit('SET_MESSAGE_COLOR', "danger")
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")// Replace 'yourMutation' with the actual name of your mutation
                }, 3000)
                console.error(error);
                throw error;
            }
        },
        async processadpurchase({commit}, credentials) {
            try {
                const response = await instance.post('getpurchasedads', credentials);
                const userData = response.data;
                console.log(userData);
                commit('SET_PURCHASE_RESPONSE', userData);
            } catch (error) {
                commit('SET_PURCHASE_RESPONSE', error);
                console.error(error);
                throw error;
            }
        },
        async UpdateReceiptState({commit}, credentials) {
            try {
                const userData = credentials;
                // console.log(userData);
                commit('SET_RECEIPT_RESPONSE', userData);
            } catch (error) {
                commit('SET_RECEIPT_RESPONSE', error);
                console.error(error);
                throw error;
            }
        },
        async checkTransaction({commit}, {userId, adId}) {
            try {
                console.log(userId, adId);
                const response = await instance.get(`check-transaction/${userId}/${adId}`);
                const userData = response.data.exists;
                // console.log(userData);
                commit('SET_BUTTON_VISIBILITY', userData);
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async fetchuserpurchasedads({commit}) {
            try {
                const response1 = await instance.get('purchased-ads');
                const response2 = await instance.get('detail');

                const userData = {
                    purchasedAds: response1.data,
                    detail: response2.data
                };

                commit('SET_USER_PURCHASEDADS', userData);
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async fetchuserrefundedads({commit}) {
            try {
                const response1 = await instance.get('refunded-packages');
                const response2 = await instance.get('detail');

                const userData = {
                    refundedAds: response1.data,
                    detail: response2.data
                };

                commit('SET_USER_REFUNDEDADS', userData);
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        async updateauthuserinfo({commit}, credential) {
            try {
                const response1 = await instance.put('users/update', credential);
                const response2 = await instance.get('detail');
                const userData1 = response1.data.message;
                commit('SET_MESSAGE_RESPONSE', userData1);
                commit('SET_MESSAGE_COLOR', "success");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")
                }, 3000)
                const userData2 = response2.data;
                commit('SET_INFO_RESPONSE', userData2);
            } catch (error) {
                const userData1 = error.response.data.message;
                commit('SET_MESSAGE_RESPONSE', userData1);
                commit('SET_MESSAGE_COLOR', "danger");
                setTimeout(() => {
                    commit('SET_MESSAGE_RESPONSE', "")
                    commit('SET_MESSAGE_COLOR', "")
                }, 3000)
            }
        },
        async fetchRatingsAndComments({commit}, userId) {
            try {
                const response = await axios.get(`api/ratings/${userId}`);
                const ratingsAndComments = response.data;
                commit('SET_RATINGS_AND_COMMENTS', ratingsAndComments);
            } catch (error) {
                console.error('Error fetching ratings and comments:', error);
            }
        },
        async trackUsage({commit}, usageData) {
            try {
                await instance.post('/usage-data', usageData)
                console.log(1)
            } catch (error) {
                console.error('Error fetching ratings and comments:', error);
            }
        },
        async fetchUsageData({commit}, params) {
            try {
                await instance.get(`/usage-data?date_range=${params}`)
                    .then(response => {
                        commit('setUsageData', response.data);
                    })
            } catch (error) {
                console.error(error);
            }
        },
        async fetchUsers({commit}) {
            await instance.get('users')
                .then(response => {
                    const users = response.data;
                    commit('SET_USERS', users);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        async deleteUser({commit}, userId) {
            console.log(userId)
            await instance.delete(`/users/${userId}`)
                .then(response => {
                    console.log(response.data.message);
                    commit('deleteUser', userId);
                })
                .catch(error => {
                    reject(error);
                });
        },
        async fetchRandomReviews({commit}) {
            await instance.get('random-reviews')
                .then(response => {
                    commit('setRandomReviews', response.data);
                })
                .catch(error => {
                    console.error('Error fetching random reviews:', error);
                });
        },
    },
});

export default store;
