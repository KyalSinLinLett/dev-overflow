<template>
	<div class="conversation">
		<h1>{{ contact ?  contact.name : 'Select a contact to start a conversation' }} </h1>
		<MessagesFeed :contact="contact" :messages="messages"/>
		<MessageComposer @send="sendMessage"/>
	</div>
</template>

<script>
	import MessagesFeed from './MessagesFeed';
	import MessageComposer from './MessageComposer';

	export default {

		props:{
			contact: {
		        type: Object,
		        default() {
		            return {}
		        }
		    },
		    messages: {
		        type: Array,
		        default() {
		            return []
		        }
		    },
		}, 
		methods: {
			sendMessage(formData){
				if(!this.contact){
					return;
				}

				formData.append('contact_id', this.contact.id);

				axios.post('/chats/conversation/send', formData)
					.then((response) => {
						this.$emit('new', response.data);
					});
			},
		}, 

		components: {MessagesFeed, MessageComposer}
	}

</script>

<style lang="scss" scoped>
	.conversation {
		flex: 5;
		display: flex;
		width: 80%;
		flex-direction: column;
		justify-content: space-between;	

		h1 {
			font-size: 20px;
			padding: 10px;
			margin: 0;
			border-bottom: 1px solid lightgray;
		}

	}
</style>