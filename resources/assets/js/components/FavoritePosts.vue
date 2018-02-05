<template>

    <div class="container">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h4 class="panel-title pull-left">
                    Posts <span class="badge">{{ posts.total }} </span>
                </h4>

                <div class="inner-addon left-addon pull-right">
                    <i class="fa fa-search"></i>

                    <input type="text" class="form-control pull-right" id="searchQuery" v-model="searchQuery"> 
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="panel-body">

                 {{ isAuthenticated }}

                <span class="pull-right">
                    <vue-pagination  :pagination="posts" :offset="4" @paginate="getPosts()"> </vue-pagination>
                </span>

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="post,key in filteredList">

                            <td>{{ key}}.(#{{ post.id }}) - {{ post.title }}</td>

                            <td>{{ post.created_at }}</td>

                            <td>

                                <button class="btn btn-xs btn-info"><i class="fa fa-eye" @click="showPost(post)"></i></button>
                                <button class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o" @click="editPost(post)"></i></button>
                                <button class="btn btn-xs btn-danger"><i class="fa fa-trash-o" @click="deletePost(post)"></i></button>

                                <favorite :post="post" :favorited="post.favorite"></favorite>

                                
                            </td>

                        </tr>
                    </tbody>

                </table>

                <span class="pull-right">
                    <vue-pagination  :pagination="posts" :offset="4" @paginate="getPosts()"> </vue-pagination>
                </span>
            </div>
        </div>

    </div>


</template>


<script>

let vuePagination = require('./PaginationComponent.vue');
let FavoriteComponent = require('./Favorite.vue');

export default{

    components: { 

        vuePagination,
        'favorite': FavoriteComponent
    }, 

    data() { 
    
        return { 

            posts: { 
        
                total: 0, 

                per_page: 20, 

                from: 1, 

                to: 0, 

                current_page: 1, 

                data: [],
            }, 

            offset: 4, 

            post: {}, 
            searchQuery: '',

            authenticated: false,
        }

    }, 


    computed: {

        filteredList() {

            console.log('filteredList()...');

            console.log(this.posts);

            return this.posts.data.filter(item => {
                return item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                item.body.toLowerCase().includes(this.searchQuery.toLowerCase());
            })
        }, 

        isAuthenticated() {

            return this.authenticated;

        }
    },

    methods: {

        getPosts() { 
        
            console.log('getPosts()...');
            console.log('current_page: ' + this.posts.current_page );

            axios.get(`/my_favorites?page=${this.posts.current_page}`)
                .then((response) => { 

                    console.log(response);

                    this.posts = response.data;

                })
                .catch((error) => { 

                    console.log('Handle server error from here.');
                    console.log(response);

                });
        }, 

    }, 

    mounted() { 
            
        console.log('FavoritePosts: mounted()...');

    }, 

    created() { 

        console.log('FavoritePosts: created()...');

        console.log('window.Laravel');
        //console.log(window.Laravel);

        if (typeof window.Laravel.user !== typeof undefined  && null !== window.Laravel.user) { 
            console.log(window.Laravel.user); 
            this.authenticated = true;
        }

        this.getPosts();

    }

  }
</script>

<style>

/* enable absolute positioning */
.inner-addon { 
   position: relative; 
   margin-right:3px;
}

/* style icon */
.inner-addon .fa {
    position: absolute;
    padding: 10px;
  pointer-events: none;
}

/* align icon */
.left-addon .fa  { left:  0px;}
.right-addon .fa { right: 0px;}

/* add padding  */
.left-addon input  { padding-left:  30px; }
.right-addon input { padding-right: 30px; }
</style>
