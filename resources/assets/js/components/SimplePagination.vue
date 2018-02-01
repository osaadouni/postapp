<template>

    <div :class="{'loading': loading}" class="pager-data-wrapper">


        <slot :result="result">

            <div class="text-center alert-info pb-3">

                <span v-if="!loading">
                    
                    {{ result.length }} items found. render it using v-for="item in result"

                </span>

                <span v-if="loading">

                    Loading... 

                </span>

            </div>


        </slot>


        <article class="pager-result" v-for="item in result" :key="item.id">

            <figure>

                <img :src="item.cover_pic" alt=""> 

            </figure>

            <section>

                <h3><a href="">{{ item.id }} {{ item.title }} </a></h3>

                <footer>{{ item.created_at }}</footer>

            </section>

        </article>


        <div class="pager-link text-center">

            <button @click.prevent="loadMore" class="btn btn-block btn-primary"
                    
                    :class="{loading: loading}" :disabled="loading || !nextPageUrl">
                        
                    {{ loading ? 'Loading...' : moreBtnText }} 

            </button>

        </div>

    </div>

</template>


<simple-pagination url="/posts">

    <template scope="data">

        <article class="pager-result" v-for="item in data.result" :key="item.id">

            <figure>

                <img :src="item.cover_pic" alt="">

            </figure>


            <section>

                <h3><a href="">@{{ item.id }} @{{ item.title }}</a></h3>

                <footer>@{{ item.created_at }}</footer>

            </section>

        </article>

    </template>

</simple-pagination>

<script>

export default { 

    props: { 

        url: { 

            required: true 
        }, 

        moreBtnText: {
    
            type: String, 

            default: 'Load More...'
        }

    },

    data() {

        return {

            result: [], 

            loading: true, 

            nextPageUrl: null,
        }
    }, 

    created() { 

        // load the data initially

        this.fetchData();
    }, 

    methods: {

        fetchData(url) { 

            let vm = this;

            let endpoint = url ? url : this.url;

            // show loader 

            vm.loading = true;

            // fetch the data from passed url property 

            axios.get(endpoint).then((res) => {

                // hide the loader 

                vm.loading = false;


                // Assign returned data 

                if ( url ) { 

                    // push next page into result

                    _.forEach(res.data.data, (item) => vm.result.push(item))

                } else {

                    // add first page

                    vm.result = res.data.data;
                
                }

                // assign next page url 

                vm.nextPageUrl = res.data.next_page_url;
                
            }).catch((err) => {

                vm.loading = false;

            })
        },

        nextPage() { 

            this.fetchData(this.nextPageUrl);
        }
    
    }
}

</script>
