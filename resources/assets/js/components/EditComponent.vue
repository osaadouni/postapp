<template>


<!--  <transition name="modal"> -->

    <div class="modal modal-mask" tabindex="-1" role="dialog" style="display: block">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                     <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title">
                        Edit Post #{{ post.id }}
                    </h4>
                </div>
                
                <div class="modal-body">

                    <form>
                        <div class="form-group" :class="{'has-danger': errors.title}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" v-model="post.title"  placeholder="Title">
                            <small v-if="errors.title" :class="{'text-danger': errors.title}"><strong>{{ errors.title[0] }}</strong></small>

                         </div>
                         <div class="form-group" :class="{'has-danger': errors.body}">
                             <label for="body">Body</label>
                             <textarea  class="form-control" rows=10 id="body" v-model="post.body" placeholder="Body"></textarea>
                             <small v-if="errors.body" :class="{'text-danger': errors.body}"><strong>{{ errors.body[0] }}</strong></small>

                         </div>

                    </form>

                </div>
                
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" @click="close">Cancel <i class="fa fa-times"></i></button>
                    <button type="button" class="btn btn-success" @click="update">Update <i class="fa fa-check"></i></button>

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
            errors: {}
        }
    },

    created() { 

        console.log('[EditComponent] created()...');
    }, 

    mounted() { 

        console.log('[EditComponent] mounted()...');
    }, 

    methods: { 

        close() { 

            this.$emit('close');

        },

        update() {

            console.log('update()...');
            console.log(this.post);

            axios.patch(`/posts/${this.post.id}`, this.post).then((response) => { 

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
