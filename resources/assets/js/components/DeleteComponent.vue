<template>


<!--  <transition name="modal"> -->

    <div class="modal modal-mask" tabindex="-1" role="dialog" style="display: block">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                     <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title">
                        Delete Post #{{ post.id }}
                    </h4>
                </div>
                
                <div class="modal-body">

                    <div class="alert alert-warning">

                        Are you sure you want to delete this post?
                    </div>

                </div>
                
                <div class="modal-footer">

                      <button type="button" class="btn btn-default" @click="close">No <i class="fa fa-times"></i></button>
                      <button type="button" class="btn btn-success" @click="remove">Yes <i class="fa fa-check"></i></button>

                </div>

            </div>

        </div>

    </div>

<!-- </transition>  -->
 
</template>


<script>

export default {

    props: [

        'openModal',

        'post'
    ], 

    data() { 

        return {
            errors: {}, 
            message: ''
        }
    },

    created() { 

        console.log('[DeleteComponent] created()...');
    }, 

    mounted() { 

        console.log('[DeleteComponent] mounted()...');
    }, 

    methods: { 

        close() { 

            this.$emit('close');

        },
        
        remove() {
            
            console.log('remove()...');
            console.log(this.post);

            axios.delete(`/posts/${this.post.id}`, this.post).then((response) => { 

                this.$emit('refresh');
                this.close();
            })
            .catch((error) => this.errors = error.response.data.errors )
        }
    }
}

</script>


<style>

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

</style>
