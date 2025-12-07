// import { createRouter, createWebHashHistory } from 'vue-router';
// import Home from "../Components/pages/Home";
// import Signup from "../Components/pages/Signup";
// import Login from "../Components/pages/Login";
// import Destination from "../Components/pages/Destination";
// import appModal from "../Components/pages/appModal";
// import UserAdsDetails from "../Components/pages/UserAdsDetails";
// import postAds from "../Components/pages/postAds";
// import about from "../Components/pages/About";
// import UserReceipt from "../Components/pages/UserReceipt";
// import UserPurchasedAds from "../Components/pages/UserPurchasedAds";
// import UpdateUserInfo from "../Components/pages/UpdateUserInfo";
// import AdminPanel from "../Components/pages/AdminPanel";
// import ReviewsContactsAdminPanel from "../Components/pages/Reviews&ContactsAdminPanel";
// import store from "../store/modules/currentUser";
// import RefundedPackages from "../Components/pages/RefundedPackages.vue";
// import RefundQueriesAdminPanel from "../Components/pages/RefundQueriesAdminPanel.vue";
//
//
// const routes = [
//     { path: '/', component: Home },
//     { path: '/home', component: Home, name: 'Home', },
//     { path: '/signup', component: Signup, beforeEnter: checkToken },
//     { path: '/login', component: Login, beforeEnter: checkToken },
//     { path: '/destination', component: Destination },
//     { path: '/details', component: appModal },
//     { path: '/myads', component: UserAdsDetails, beforeEnter: nonAuth },
//     { path: '/postad', component: postAds, beforeEnter: nonAuth },
//     { path: '/about', component: about },
//     { path: '/user-receipt', component: UserReceipt, beforeEnter: nonAuth },
//     { path: '/purchased-ads', component: UserPurchasedAds, beforeEnter: nonAuth },
//     { path: '/user-update', component: UpdateUserInfo, beforeEnter: nonAuth },
//     { path: '/admin-panel', component: AdminPanel, beforeEnter: nonAuth,simpleUser },
//     { path: '/contacts-reviews', component: ReviewsContactsAdminPanel, beforeEnter: nonAuth,simpleUser },
//     { path: '/refunded-packages', component: RefundedPackages, beforeEnter: nonAuth,simpleUser },
//     { path: '/refunded-packages', component: RefundedPackages, beforeEnter: nonAuth,simpleUser },
//     { path: '/refunded-queries', component: RefundQueriesAdminPanel, beforeEnter: nonAuth,simpleUser },
//
// ];
//
// function checkToken(to, from, next) {
//     const token = localStorage.getItem('token');
//     const userInfo = store.state.userinfo;
//
//    if(token){
//        if (token && userInfo.role === "Admin") {
//            next('/admin-panel');
//        } else if (token) {
//            next('/Home');
//        } else {
//            next();
//        }
//    }else {
//        next();
//    }
// }
//
// function nonAuth(to, from, next) {
//     const token = localStorage.getItem('token');
//     if (!token) {
//         next('/Home');
//     }
//     else {
//         next();
//     }
// }
// function simpleUser(to, from, next) {
//     const token = localStorage.getItem('token');
//     const userInfo = store.state.userinfo;
//     console.log(userInfo.role)
//     if (token && userInfo.role === "User") {
//         next('/Home');
//     } else {
//         next();
//     }
// }
//
//
// const router = createRouter({
//     history: createWebHashHistory(),
//     routes,
// });
//
// store.watch(() => store.state.userinfo, () => {
//     const userInfo = store.state.userinfo;
//     if (userInfo.role === "Admin") {
//         router.replace('/admin-panel');
//     }
//     console.log(userInfo.role);
//     // else {
//     //     router.replace('/Home');
//     // }
// });
//
// export function navigateTo(routeName) {
//     router.push({ name: routeName });
// }
//
// export default router;
//


import { createRouter, createWebHashHistory } from 'vue-router';
import Home from "../Components/pages/Home";
import Signup from "../Components/pages/Signup";
import Login from "../Components/pages/Login";
import Destination from "../Components/pages/Destination";
import appModal from "../Components/pages/appModal";
import UserAdsDetails from "../Components/pages/UserAdsDetails";
import postAds from "../Components/pages/postAds";
import about from "../Components/pages/About";
import UserReceipt from "../Components/pages/UserReceipt";
import UserPurchasedAds from "../Components/pages/UserPurchasedAds";
import UpdateUserInfo from "../Components/pages/UpdateUserInfo";
import AdminPanel from "../Components/pages/AdminPanel";
import ReviewsContactsAdminPanel from "../Components/pages/Reviews&ContactsAdminPanel";
import store from "../store/modules/currentUser";
import RefundedPackages from "../Components/pages/RefundedPackages.vue";
import RefundQueriesAdminPanel from "../Components/pages/RefundQueriesAdminPanel.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/home', component: Home, name: 'Home' },
    { path: '/about', component: about },
    { path: '/signup', component: Signup, beforeEnter: checkToken },
    { path: '/login', component: Login, beforeEnter: checkToken },
    { path: '/destination', component: Destination, beforeEnter: userRoleGuard },
    { path: '/details', component: appModal },
    { path: '/myads', component: UserAdsDetails, beforeEnter: companyRoleGuard },
    { path: '/postad', component: postAds, beforeEnter: companyRoleGuard },
    { path: '/user-receipt', component: UserReceipt, beforeEnter: userRoleGuard },
    { path: '/purchased-ads', component: UserPurchasedAds, beforeEnter: userRoleGuard },
    { path: '/user-update', component: UpdateUserInfo, beforeEnter: multipleRoleGuard },
    { path: '/admin-panel', component: AdminPanel, beforeEnter: adminRoleGuard },
    { path: '/contacts-reviews', component: ReviewsContactsAdminPanel, beforeEnter: adminRoleGuard },
    { path: '/refunded-packages', component: RefundedPackages, beforeEnter: userRoleGuard },
    { path: '/refunded-queries', component: RefundQueriesAdminPanel, beforeEnter: adminRoleGuard },
];

function checkToken(to, from, next) {
    const token = localStorage.getItem('token');
    if (token) {
        next('/admin-panel');
    } else {
        next();
    }
}

function multipleRoleGuard(to, from, next) {
    const token = localStorage.getItem('token');
    const userInfo = store.state.userinfo;
    if ((token && userInfo.role === "User") || (token && userInfo.role === "Company") || (token && userInfo.role === "Admin"))  {
        next();
    } else {
        next('/Home');
    }
}
function userRoleGuard(to, from, next) {
    const token = localStorage.getItem('token');
    const userInfo = store.state.userinfo;
    if ((token && userInfo.role === "User") || !token)  {
        next();
    } else {
        next('/Home');
    }
}
function companyRoleGuard(to, from, next) {
    const token = localStorage.getItem('token');
    const userInfo = store.state.userinfo;
    if (token && userInfo.role === "Company")  {
        next();
    } else {
        next('/Home');
    }
}
function adminRoleGuard(to, from, next) {
    const token = localStorage.getItem('token');
    const userInfo = store.state.userinfo;
    if (token && userInfo.role === "Admin") {
        next();
    } else {
        next('/Home');
    }
}
const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

store.watch(() => store.state.userinfo, () => {
    const userInfo = store.state.userinfo;
    if (userInfo.role === "Admin") {
        router.replace('/admin-panel');
    }
    console.log(userInfo.role);
});

export function navigateTo(routeName) {
    router.push({ name: routeName });
}

export default router;
