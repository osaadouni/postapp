<template>


<!--  <transition name="modal"> -->

    <div class="modal modal-mask" tabindex="-1" role="dialog" style="display: block">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                     <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title">
                        Detail Post #{{ post.id }} 
                    </h4>
                </div>
                
                <div class="modal-body">
                        <h3> {{ post.title }} </h3>
                        <p> {{ post.body }} </p>

                </div>
                
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" @click="close">Close <i class="fa fa-times"></i></button>

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
        }
    },

    created() { 

        console.log('[ShowComponent] created()...');
        console.log(this.post);
    }, 

    mounted() { 

        console.log('[ShowComponent] mounted()...');
    }, 

    methods: { 

        close() { 

            this.$emit('close');

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
