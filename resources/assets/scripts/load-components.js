// Vue.component('component-name', require('path/to/component'))

//navigation menus
Vue.component('main-menu', require('./components/navigation/MainNavigationMenu.vue'));
Vue.component('mobile-menu', require('./components/navigation/MobileNavigationMenu.vue'));

//plugins
Vue.component('social-icons', require('./components/SocialMediaIcons.vue'));
Vue.component('kma-slider', require('./components/KMASliderModule.vue'));
// Vue.component('portfolio-gallery', require('./components/PortfolioGallery.vue'));
Vue.component('contact-form', require('./components/ContactForm.vue'));
// Vue.component('fit-text', require('./components/FitText.vue'));
Vue.component('photo-gallery', require('./components/PhotoGallery.vue'));

//search
Vue.component('omni-bar', require('./components/fields/OmniBar.vue'));
Vue.component('acreage-field', require('./components/fields/Acreage.vue'));
Vue.component('sqft-field', require('./components/fields/TotalSqft.vue'));
Vue.component('bathrooms-field', require('./components/fields/Bathrooms.vue'));
Vue.component('bedrooms-field', require('./components/fields/Bedrooms.vue'));
Vue.component('max-price-field', require('./components/fields/MaxPrice.vue'));
Vue.component('min-price-field', require('./components/fields/MinPrice.vue'));
Vue.component('status-field', require('./components/fields/Status.vue'));
Vue.component('property-type', require('./components/fields/PropertyType.vue'));
Vue.component('area-field', require('./components/fields/Area.vue'));
Vue.component('details-field', require('./components/fields/Details.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('quick-search', require('./components/QuickSearch.vue'));
Vue.component('sort-form', require('./components/SortForm.vue'));
Vue.component('video-bg', require('./components/VideoBackground.vue'));