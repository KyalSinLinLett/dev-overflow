<template>
	<div class="contacts-list">
		<ul>
			<li v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected' : contact == selected }">
				<div class="avatar">
					<img :src="`/storage/${contact.image}`" :alt="contact.name">
				</div>
				<div class="contact">
        			<p class="name">{{ contact.name }}</p>
					<p class="email">{{ contact.email }}</p>
				</div>
				<span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {	

		data() {
			return {
				selected: this.contacts.length ? this.contacts[0] : null
			};
		},

		props: {
			contacts: {
				type: Array,
				default: []
			}
		}, 

		methods: {
			selectContact(contact){
				this.selected = contact;

				this.$emit('selected', contact);
			}	
		}, 

		computed: {
			sortedContacts() {
				return _.sortBy(this.contacts, [(contact) => {
					if(contact == this.selected) {
						return Infinity;
					}
					return contact.unread;
				}]).reverse();
			}
		}
	}
</script>


<style lang="scss" scoped>
.contacts-list {
	flex: 2;
	max-height: 600px;
	overflow: scroll;
	border-left: 1px solid lightgray;
	margin-bottom: 0px;

	ul {
		list-style-type:none;
		padding: 0px;

		li {
			display: flex;
			padding-left: 17px;
			padding-top: 1px;
			border-bottom: 1px solid lightgray;
			height: 70px;
			position: relative;
			cursor: pointer;
			margin-right: 0px;

			&.selected {
				background: #dfdfdf;
			}

			span.unread {
				background: red;
				color: #fff;
				position: absolute;
				right: 11px;
				top: 20px;
				display: flex;
				font-weight: 700;
				min-width: 20px;
				justify-content: center;
				align-items: center;
				line-height: 20px;
				font-size: 12px;
				padding: 0 4px;
				border-radius: 3px;
			}

			.avatar {
				flex: 1;
				display: flex;
				align-items: center;

				img {
					width: 55px;
					border-radius: 50%;
					margin: 0 auto;
				}
			}

			.contact {
				flex: 2;
				font-size: 13px;
				overflow: hidden;
				display: flex;
				flex-direction: column;
				justify-content: center;

				p {
					margin: 0;

					&.name {
						font-weight: bold; 
					}
				}
			}

		}

	}

	@media (max-width: 700px) {
		ul {
			list-style-type:none;
			padding: 0px;

			li {

				display: flex;
				justify-content: center;
				padding-right: 0px;
				border-bottom: 1px solid lightgray;
				height: 65px;
				// position: relative;
				cursor: pointer;
				margin-right: 0px;

				&.selected {
					background: #dfdfdf;
				}

				.avatar {
					align-items: center;
					text-align: center;

					img {
						width: 55px;
						border-radius: 50%;
						margin-left: 0px;
					}
				}

				.contact {
					visibility: hidden;

				}
			}
		}
	}


}
</style>