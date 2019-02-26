if (!window._babelPolyfill) {
    window._babelPolyfill = require('babel-polyfill');
}

window.Vue = require('vue');
window.axios = require('axios');
window._ = require("lodash");

import { cacheAdapterEnhancer, throttleAdapterEnhancer } from 'axios-extensions';

window.http = axios.create({
	baseURL: '/',
	headers: { 'Cache-Control': 'no-cache' },
	adapter: throttleAdapterEnhancer(axios.defaults.adapter, { threshold: 2 * 1000 })
});

require('./load-components')

import {VueMasonryPlugin} from 'vue-masonry';
Vue.use(VueMasonryPlugin)

import PortalVue from 'portal-vue';
Vue.use(PortalVue);

import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

const app = new Vue({
    el: '#app',

    data: {
        clientHeight: 0,
        windowHeight: 0,
        windowWidth: 0,
        isScrolling: false,
        scrollPosition: 0,
        footerStuck: false,
        mobileMenuOpen: false,
        galleryIsOpen: false
    },

    methods: {
        handleScroll () {
            this.scrollPosition = window.scrollY;
            this.isScrolling = this.scrollPosition > 40;
        },
        toggleMenu() { 
            this.mobileMenuOpen = ! this.mobileMenuOpen;
        },
        openGallery() {
            this.galleryIsOpen = true;
        },
        closeGallery() {
            this.galleryIsOpen = false;
        }
    },

    mounted () {
        this.footerStuck = window.innerHeight > this.$root.$el.children[0].clientHeight;
        this.clientHeight = this.$root.$el.children[0].clientHeight;
        this.windowHeight = window.innerHeight;
        this.windowWidth = window.innerWidth;
        this.handleScroll();
    },

    created () {
        window.addEventListener('scroll', this.handleScroll);
    },

    destroyed () {
        window.removeEventListener('scroll');
    }

})
