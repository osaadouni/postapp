<template>
    <span>
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite(post)">
            <i class="fa fa-heart"></i>
        </a>

        <a href="#" v-else @click.prevent="favorite(post)">
            <i class="fa fa-heart-o"></i>
        </a>
    </span>

</template>

<script>

export default {

    props: ['post', 'favorited'], 

    data() { 

        return {
            
            isFavorited: '',
        }
    },

    mounted() { 

        console.log('Favorite: mounted()...');
    
        this.isFavorited = this.isFavorite ? true : false; // isFavorite() <= computed prop 
    }, 

    computed: {
    
        isFavorite() { 
            return this.favorited;  <= prop
        }
    },

    methods: {
            
        favorite(post) { 

            axios.post('/favorite/'+post)
                .then(response => this.isFavorited = true)
                .catch(response => console.log(response.data));
        }, 

        unFavorite(post) { 
    
            axios.post('/unfavorite/'+post)
                .then(response => this.isFavorited = false)
                .catch(response => console.log(response.data));
        }

    }


}
