<template>
    <div class="container">
        <button class="btn btn-outline-info btn-block" @click="likePost" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {

        props: ['id', 'likes', 'type'],

        data: function (){
            return {
                status: this.likes,
            }
        }, 

        methods: {
            likePost() {
                axios.post('/like/' + this.id + '/' + this.type)
                    .then(response => {
                        this.status = !this.status;
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

        }

    }
</script>
