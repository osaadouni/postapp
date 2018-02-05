
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('posts-component', require('./components/PostsComponent.vue'));
let postsComponent =  require('./components/PostsComponent.vue');
let favoritePosts =  require('./components/FavoritePosts.vue');

/** 
 * Create a global Event hub 
 */
Vue.prototype.$eventHub = new Vue();

const app = new Vue({

    el: '#app',

    components: {
        'vue-posts': postsComponent,
        'favorite-posts': favoritePosts,
    }, 

    mounted() {

        console.log('mounted()...');

    },

    created() { 
        console.log('created()...');
    },

    methods: {

    }

});
