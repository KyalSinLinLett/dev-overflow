<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="`message${message.to == contact.id ? ' sent' : ' received'}`" :key="message.id">
                <div class="text">
                    {{ message.text }}
                </div>
                <div>	
	                <small id="date">{{ message.created_at.substring(0, 10) + ' ' + message.created_at.substring(11, 19)+'GMT' }}</small>              	
                </div>

                <div class="mt-2">
                	<img class="image" v-if="message.file && message.type == 'image'" :src="`/storage/${message.file}`">
                	<a class="file" onclick="return confirm('Do you want to download this file?')" v-if="message.file && message.type == 'file'" :href="'/chats/download-file' + `${message.file}`.substring(12)">{{ `${message.file}`.substring(24) }}</a>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
	export default {

		props: {
			contact: {
		        type: Object,
		    },
		    messages: {
		        type: Array,
		        required: true
		    },
		},

		methods: {
			scrollToBottom(){
				setTimeout(() => {
					this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
				}, 50);
			}
		}, 

		watch: {
			contact(contact) {	
				this.scrollToBottom();
			}, 

			messages(messages) {
				this.scrollToBottom();  
			}
		}
	}
</script>

<style lang="scss">
	.feed {
		background: #f1f2f1;;
		height: 480px;
		overflow: scroll;
	}

	ul {
		list-style-type: none;
		padding: 5px;

		li {
			&.message {
				margin: 10px 0;
				width: 100%;

				.text {
					max-width: 300px;
					color: white;
					border-radius: 1rem;
					padding: 12px;
					display: inline-block; 
					box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);
					font-weight: 700;
				}
				
				&.received {
					text-align: left;
					
					.text {
						background: #4d6066;
					}

				}

				&.sent {
					text-align: right;
					
					.text {
						background: #52919b;
					}

				}

			}

			.image {
				width: 55%;
				border-radius: 1.2rem;
				box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);
			}

			.file {
				text-decoration: none;
				border-radius: 1rem;
				box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);
				color: white;
				font-size: 15px;
				background: #81c4f9;
				padding: 5px;
				padding-right: 15px;
				padding-left: 15px;
			}

			#date {
				font-size: 8px;
				margin-right: 7px;
				margin-left: 7px;
			}
		}
	}
</style>