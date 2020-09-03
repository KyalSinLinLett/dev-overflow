<template>
    <div class="container">
        <button class="btn btn-outline-info btn-block" @click="likePost" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {

        // props: ['id', 'likes', 'likecount'],
        props: ['id', 'likes'],

        data: function (){
            return {
                status: this.likes,
                // l_count: this.likecount,
            }
        }, 

        methods: {
            likePost() {
                axios.post('/like/' + this.id)
                    .then(response => {
                        this.status = !this.status;
                        // window.location = window.location; // this is temporary. Will make the like count change without reloading.
                        // window.location = '/post/' + this.id;
                        // this.l_count = response.data.like_count;
                    })
                    .catch(errors => {
                        if (errors.response.status == 401){
                            window.location = '/login';
                        }
                    });
            }
        },

        computed: {
            buttonText() {
                return (this.status) ? 'Unlike' : 'Like';
            },

            // likeCount() {
            //     return this.l_count;
            // }

        }

    }
</script>
