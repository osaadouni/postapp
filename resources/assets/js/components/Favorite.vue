<template>
    <span>
        <a href="#" v-if="isFavorite" @click.prevent="unFavorite(post)">
            <i class="fa fa-heart"></i> <!--   / isFav={{ isFavorited }} / fav={{ favorited }} -->
        </a>

        <a href="#" v-else @click.prevent="favorite(post)">
            <i class="fa fa-heart-o"></i> <!--   / isFav={{ isFavorited }} / fav={{ favorited }} -->
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

        //console.log('this.isFavorited: ' + this.isFavorited );
    }, 

    beforeMount()  { 
        //console.log('beforeMount()...');
    }, 

    created() { 

        //console.log('[Favorite]: created()...');

    },

    watch: {
        isFavorited: function(v) { 
            //console.log('[Watch isFavorited()] .. v = ' + v);
        }
    },

    computed: {
    
        isFavorite() { 
            //console.log('[isFavorite()] this.post.id: ' + this.post.id+'; this.isFavorited: ' + this.isFavorited );
            this.isFavorited = this.favorited;  // <= prop
            return this.favorited;  // <= prop
        }
    },

    methods: {
            
        favorite(post) { 

            console.log('favorite():' ); console.log(post.id );

            axios.post('/favorite/'+post.id)
                .then(response => { 
                    console.log(response);
                    if (typeof response.data.error !== typeof undefined) { 

                        console.log(response.data.error);

                        if (typeof response.data.error_code !== typeof undefined && 'auth' == response.data.error_code ) { 
                            window.location.href='/login'; 
                        }
                        return false;
                    }

                    console.log('emit favorite event!');
                    this.$eventHub.$emit('updateFavoriteStatus', { post: post, favStatus: true });
                })
                .catch(response => console.log(response.data));
        }, 

        unFavorite(post) { 

            console.log('unFavorite():' ); console.log(post.id );
    
            axios.post('/unfavorite/'+post.id)
                .then(response => { 
                    console.log('emit unfavorite event!');
                    this.$eventHub.$emit('updateFavoriteStatus', { post: post, favStatus: false });
                        
                })
                .catch(response => console.log(response.data));
        }

    }

}

</script>
