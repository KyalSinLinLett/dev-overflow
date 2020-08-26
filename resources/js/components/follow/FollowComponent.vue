<template>
    <div class="container">
        <button class="btn btn-primary btn-block" @click="followUser" v-text="buttonText">Follow</button>
    </div>
</template>

<script>
    export default {
        
        props: ['id', 'follows'],

        data: function (){
            return {
                status: this.follows,
            }
        }, 

        methods: {
            followUser() {
                axios.post('/follow/' + this.id)
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
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        },

    }
</script>
