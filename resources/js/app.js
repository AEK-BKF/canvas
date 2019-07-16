import Vue from 'vue';
import Base from './base';
import Routes from './routes';
import NProgress from 'nprogress';
import VueRouter from 'vue-router';
import moment from 'moment-timezone';

require ('bootstrap');

window.Popper = require('popper.js').default;

// Set the default app timezone
moment.tz.setDefault(Canvas.timezone);

// Prevent the production tip on Vue startup
Vue.config.productionTip = false;

Vue.mixin(Base);

Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: window.Canvas.path,
});

NProgress.configure({
    showSpinner: false
});

// Start the progress bar animation if not on an initial page load
// todo: is there a way to ignore this when hitting the Load More button on index lists?
router.beforeResolve((to, from, next) => {
    if (to.path) {
        NProgress.start()
    }
    next()
});

// Complete the animation of the route progress bar
router.afterEach(() => {
    NProgress.done()
});

new Vue({
    el: '#canvas',

    router,
});
