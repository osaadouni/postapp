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

                auth: {{ isAuthenticated }} - userID: {{ user_id }}

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
                                
                                <favorite :post="post" :favorited="post.favorite" v-if="!post.owner"></favorite>

                                
                            </td>

                        </tr>
                    </tbody>

                </table>

                <span class="pull-right">
                    <vue-pagination  :pagination="posts" :offset="4" @paginate="getPosts()"> </vue-pagination>
                </span>
            </div>
        </div>


         <show-modal v-if="showActive" :openModal="showActive" :post="post" @close='closeModal'></show-modal>

    </div>


</template>


<script>

let vuePagination = require('./PaginationComponent.vue');
let AddModal = require('./AddComponent.vue');
let ShowModal = require('./ShowComponent.vue');
let EditModal = require('./EditComponent.vue');
let DeleteModal = require('./DeleteComponent.vue');

let FavoriteComponent = require('./Favorite.vue');

export default{

    components: { 

        vuePagination,

        ShowModal, 

        'favorite': FavoriteComponent
    }, 

    /** 
    props: {
        pagination: {
          type: Object,
          required: true
        },
        offset: {
          type: Number,
          default: 4
        }
    },
    **/

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

            // modal props
            showActive:   false, 

            post: {}, 
            searchQuery: '',

            authenticated: false,
            user_id: '',
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

            axios.get(`/posts?page=${this.posts.current_page}`)
                .then((response) => { 

                    console.log(response);

                    this.posts = response.data;

                })
                .catch((error) => { 

                    console.log('Handle server error from here.');
                    console.log(response);

                });
        }, 

        showPost(post) { 
            console.log('showPost()...');
            this.showActive = true;
            this.post = post;
        },

        closeModal() {
    
            console.log('closeModal()...');

            this.showActive   = false;
        }

    }, 

    mounted() { 
            
        console.log('PostsComponent: mounted()...');

    }, 

    created() { 

        console.log('PostsComponent: created()...');

        console.log('window.Laravel');
        //console.log(window.Laravel);

        if (typeof window.Laravel.user !== typeof undefined  && null !== window.Laravel.user) { 
            console.log(window.Laravel.user); 
            this.authenticated = true;
            this.user_id = window.Laravel.user.id;

        }

        this.getPosts();

        // take care of favorite flag update
        this.$eventHub.$on('updateFavoriteStatus', (data) => { 
            console.log('Incoming => updateFavoriteStatus ');
            console.log(data);
            console.log(data.post.id);
            console.log(data.favStatus);
            data.post.favorite = data.favStatus;
        })
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
