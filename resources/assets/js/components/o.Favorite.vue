<template>
    <span>
        <a href="#" v-if="isFavorite" @click.prevent="unFavorite(post)">
            <i class="fa fa-heart"></i>  / isFav={{ isFavorited }} / fav={{ favorited }}
        </a>

        <a href="#" v-else @click.prevent="favorite(post)">
            <i class="fa fa-heart-o"></i>  / isFav={{ isFavorited }} / fav={{ favorited }}
        </a>
    </span>

</template>

<script>

export default {

    props: ['post', 'favorited'], 

    data() { 

        return {
            
            isFavorited: this.favorited
        }
    },

    mounted() { 

        //console.log('[Favorite]: mounted()...');
    
        this.isFavorited = this.isFavorite ? true : false; // isFavorite() <= computed prop 

        console.log('this.isFavorited: ' + this.isFavorited );
    }, 

    beforeMount()  { 
        console.log('beforeMount()...');
    }, 

    created() { 

        console.log('[Favorite]: created()...');

    },

    watch: {
        isFavorited: function(v) { 
            console.log('[Watch isFavorited()] .. v = ' + v);
        }
    },

    computed: {
    
        isFavorite() { 
            console.log('[isFavorite()] this.post.id: ' + this.post.id+'; this.isFavorited: ' + this.isFavorited );
            this.isFavorited = this.favorited;  // <= prop
            return this.favorited;  // <= prop
        }
    },

    methods: {
            
        favorite(post) { 
            console.log('favorite():' ); console.log(post.id );

            //this.$forceUpdate();

            axios.post('/favorite/'+post.id)
                .then(response => this.isFavorited = true)
                .catch(response => console.log(response.data));
        }, 

        unFavorite(post) { 

            console.log('unFavorite():' ); console.log(post.id );
    
            axios.post('/unfavorite/'+post.id)
                .then(response => this.isFavorited = false)
                .catch(response => console.log(response.data));
        }

    }

}

</script>
