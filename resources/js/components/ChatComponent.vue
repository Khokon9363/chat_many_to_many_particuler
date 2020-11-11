<template>
     <div class="row">
                <div class="card col-md-4" style="background-color: transparent;">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
						</div>
					</div>
					<div class="card-body contacts_body">
						<ul class="contacts">
						<li class="active" v-for="user in users" :key="user.id" @click="userSelected(user.id)">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="http://lorempixel.com/800/400/cats/Faker" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>{{ user.name }}</span>
								</div>
							</div>
						</li>
						</ul>
                    </div>
                </div>

                <div class="card col-md-8">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="http://lorempixel.com/800/400/cats/Faker" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>Chat with {{ receiverName }}</span>
									<p>{{ NumberOfChats }} Messages</p>
								</div>
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i> View profile </li>
									<li><i class="fas fa-ban"></i> Block </li>
								</ul>
							</div>
						</div>

						<div class="card-body msg_card_body">

                            <div v-for="allchat in allchats" :key="allchat.id">

							<div v-if="authUserId === allchat.receiver_id" class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="http://lorempixel.com/800/400/cats/Faker" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									{{ allchat.chat }}
									<span class="msg_time">8:40 AM, Today</span>
								</div>
							</div>
							<div v-else class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									{{ allchat.chat }}
									<span class="msg_time_send">8:55 AM, Today</span>
								</div>
								<div class="img_cont_msg">
							<img src="http://lorempixel.com/800/400/cats/Faker" class="rounded-circle user_img_msg">
								</div>
							</div>

                            </div>
							
						</div>

						<div class="card-footer">
							<form @submit.prevent="sendChat">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea v-model="chat" class="form-control type_msg" placeholder="Type your message..."></textarea>
								<div class="input-group-append">
									<input type="hidden" v-model="receiverId">
									<button type="submit" class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></button>
								</div>
							</div>
							</form>
						</div>

					</div>
     </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
		data(){
			return{
				users : [],
				receiverName : '',
				receiverId : '',
				NumberOfChats : '',
				allchats : [],
				authUserId : Number(document.getElementById("authUserId").value),
				chat : '',
			}
		},
		created(){
			this.getUsers()
		},
		methods:{
			getUsers(){
				axios.get('/get_users')
				.then(response =>{
					this.users = response.data
				})
				.catch(error =>{
					console.log(error)
				})
			},
			userSelected(userId){
				axios.get('/get_chat/'+userId)
				.then(response =>{
					this.allchats = response.data[0]
					this.receiverName = response.data[2].name
					this.receiverId = response.data[2].id
					this.NumberOfChats = response.data[1]
				})
				.catch(error =>{
					console.log(error)
				})
			},
			sendChat(){
				axios.post('sendChat',{
					receiver_id : this.receiverId,
					chat : this.chat
					
				})
				.then(response =>{
					console.log(response)
					this.userSelected(this.receiverId)
					this.chat = ''
				})
				.catch(error =>{
					console.log(error);
				})
			}
		}
    }
</script>
<style scoped>
  button{
	  outline: none;
  }
</style>