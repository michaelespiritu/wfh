<template>
    <div class="clearfix">

        <div
        v-for="(message, index) in $store.state.Messages.TempMessage.messages"
        :key="index"
        class="w-75 mb-3"
        :class="{'float-right mr-1': message.owner.id == $store.state.Profile.Id, 'float-left d-flex align-items-center': message.owner.id != $store.state.Profile.Id}"
        >

            <div class="pr-md-3" v-if="message.owner.id != $store.state.Profile.Id">
                <img 
                    class="rounded-circle" 
                    :src="message.owner.profile_image.encoded" 
                    :alt="message.owner.name"
                    width="50"
                    height="50">
            </div>
            <div class="rounded-lg px-2 py-2 bg-white ">
                <p class="small">{{ (message.owner.id == $store.state.Profile.Id) ? 'You' : message.owner.name }}  · {{ message.sent_at }}</p>
                <div v-html="message.message"></div>
            </div>

        </div>
        
       
    </div>
</template>

<script>

export default {
    data() {
        return {
            messages: null
        }
    },
    updated() {
        this.scrollToBottom()
    },
    methods: {
        scrollToBottom () {
            document.getElementById("chat-box").scrollTop =  document.getElementById("chat-box").scrollHeight
        }
    }
}
</script>