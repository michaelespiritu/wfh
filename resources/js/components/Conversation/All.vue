<template>
    <div class="row">
        <div class="col-2 border py-0 px-0">
            <div 
                v-for="(conversation, index) in $store.state.Messages.Messages"
                :key="index"
                @click="setTemp(conversation)"
                :class="{'bg-dark' : $store.state.Messages.TempMessage.path == conversation.path}"
                class="d-md-flex align-items-center justify-center py-2 px-2 border-bottom text-md-left text-center">
                <div class="pr-md-3">

                    <img 
                        class="rounded-circle" 
                        :src="($store.state.Profile.Role == 1) ? conversation.latest_member.data.profile_image.encoded : conversation.owner.profile_image.encoded" 
                        :alt="conversation.owner.name"
                        width="50"
                        height="50">
                </div>
                <div>
                    <p class="small text-gray-500 mb-0">
                        {{ ($store.state.Profile.Role == 1) ? conversation.members : conversation.owner.name}}
                    </p>
                    <p class="small text-gray-500 mb-0">{{ conversation.latest_message.sent_at }}</p>
                </div>
            </div>
        </div>

        <div class="col-10 border py-3 px-3">
            <div v-if="$store.state.Messages.TempMessage">
                <body-message
                    class="overflow-auto"  
                    id="chat-box" 
                    style="height: 550px"
               ></body-message>
                <hr>
                <reply></reply>
            </div>
        </div>
    </div>
</template>

<script>
import bodyMessage from './Body'
import Reply from './Reply'

export default {
    components: {
        bodyMessage,
        Reply
    },
    props: ['conversations'],
    data() {
        return {
            tempMessage: null
        }
    },
    mounted() {
        const target = document.cookie.replace(/(?:(?:^|.*;\s*)__wfh_message_target\s*\=\s*([^;]*).*$)|^.*$/, "$1")

        const checkPath = obj => obj.path === target;

        if ( !this.conversations.some(checkPath) ) {
            this.setTemp(this.conversations[this.conversations.length-1])
        } else {
            this.setTemp(this.conversations[this.conversations.map(e => e.path).indexOf(target)])
        }

        this.$store.commit('SET_MESSAGES', this.conversations)
    },
    updated() {
         setTimeout(function () {
            document.getElementById("chat-box").scrollTop =  document.getElementById("chat-box").scrollHeight
        }, 500)  
    },
    methods: {
        setTemp (data) {
            this.$store.commit('SET_TEMP_MESSAGE', data)
            document.cookie = "__wfh_message_target=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }
    }
}
</script>