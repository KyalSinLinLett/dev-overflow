<template>
	<div class="composer d-flex">	

		<input id="img" type="file" name="img" accept="image/*, .xlsx, .xls, .doc, .docx, .ppt, .pptx, .txt, .pdf, .zip"" @change="onFileSelected" style="display: none;">
		<label for="img" id="imgupload">
			<div class="d-flex">
				<div data-toggle="tooltip" data-placement="top" title="Files cannot exceed 15MB">
					<svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-file-plus my-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/>
					  <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
					</svg>
					</style>
				</div>
				
				<div>
					<span class="fadded" v-if="this.selectedFile">	
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						  <circle cx="8" cy="8" r="8"/>
						</svg>
					</span>
				</div>
			</div>
		</label>	

		<textarea v-model="message" @keydown.enter="send" placeholder="Message..."></textarea>

		<svg @click="send" id="sendicon" width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
		</svg>
		
	</div>
</template>

<script>
	export default {

		data() {
			return {
				message: '',
				selectedFile: null 
			};
		},

		methods: {
			send(e) {
				e.preventDefault();

				if (this.message == ''){
					return;
				}

				var formData = new FormData();

				formData.append('text', this.message);
				if(this.selectedFile)
				{
					formData.append('image', this.selectedFile, this.selectedFile.name);					
				}

				this.$emit('send', formData);
				this.message = '';
				this.selectedFile = null;
			}, 

			onFileSelected(e){
				this.selectedFile = e.target.files[0];
			},
		}
	}
</script>

<style lang="scss" scoped>
	.composer textarea{
		width: 90%;
		margin: 6px;
		resize: none;
		border-radius: 3px;
		border: 1px solid lightgray;
		padding: 6px;
		margin-top: 11px;
		margin-bottom: 0px;
	}

	#sendicon {
		cursor: pointer;
		margin-right: 10px;
		margin-top: 26px;
		margin-left: 10px; 
	}

	#imgupload {
		cursor: pointer;
	}

	.fadded {
		color: red;
		margin-left: -8px;
		padding: 0px;
	}

</style>