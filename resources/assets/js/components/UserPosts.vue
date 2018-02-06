<template>

    <div class="container">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h4 class="panel-title pull-left">
                    My Posts <span class="badge">{{ posts.total }} </span>
                </h4>

                <button class="btn btn-primary pull-right" @click="addPost" v-if="isAuthenticated">
                  Add New
                </button>



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


                                
                            </td>

                        </tr>
                    </tbody>

                </table>

                <span class="pull-right">
                    <vue-pagination  :pagination="posts" :offset="4" @paginate="getPosts()"> </vue-pagination>
                </span>
            </div>
        </div>


        <add-modal v-if="addActive" :openModal="addActive" @close='closeModal' @refresh="getPosts"></add-modal>

        <show-modal v-if="showActive" :openModal="showActive" :post="post" @close='closeModal'></show-modal>

        <edit-modal v-if="editActive" :openModal="editActive" :post="post" @close='closeModal'></edit-modal>

        <delete-modal v-if="deleteActive" :openModal="deleteActive" :post="post" @close='closeModal' @refresh="getPosts"></delete-modal>


    </div>


</template>


<script>

let vuePagination = require('./PaginationComponent.vue');
let AddModal = require('./AddComponent.vue');
let ShowModal = require('./ShowComponent.vue');
let EditModal = require('./EditComponent.vue');
let DeleteModal = require('./DeleteComponent.vue');



export default{

    components: { 

        vuePagination,

        AddModal, 
        ShowModal, 
        EditModal,
        DeleteModal, 

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

            // modal props
            addActive:    false, 
            showActive:   false, 
            editActive:   false, 
            deleteActive: false,

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

            axios.get(`/home/posts/user?page=${this.posts.current_page}`)
                .then((response) => { 

                    console.log(response);

                    this.posts = response.data;

                })
                .catch((error) => { 

                    console.log('Handle server error from here.');
                    console.log(response);

                });
        }, 

        addPost() { 
            console.log('addPost()...');
            this.addActive = true;
        },

        showPost(post) { 
            console.log('showPost()...');
            this.showActive = true;
            this.post = post;
        },

        editPost(post) { 
            console.log('editPost()...');
            this.editActive = true;
            this.post = post;
        },

        deletePost(post) { 
            console.log('deletePost()...');
            this.deleteActive = true;
            this.post = post;
        },

        closeModal() {

            console.log('closeModal()...');
            this.addActive    = false;
            this.showActive   = false;
            this.editActive   = false;
            this.deleteActive = false;
        }

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
