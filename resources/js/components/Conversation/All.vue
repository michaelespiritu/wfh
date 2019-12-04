<template>
    <div class="row">
        <div class="col-2 border py-0 px-0">
            <div 
                v-for="(conversation, index) in conversations"
                :key="index"
                @click="setTemp(conversation)"
                class="d-md-flex align-items-center justify-center py-2 px-2 border-bottom text-md-left text-center">
                <div class="pr-md-3">
                    <img 
                        class="rounded-circle" 
                        :src="conversation.owner.profile_image.encoded" 
                        :alt="conversation.owner.name"
                        width="50"
                        height="50">
                </div>
                <div>
                    <p class="small text-gray-500 mb-0">{{ conversation.members }}</p>
                    <p class="small text-gray-500 mb-0">{{ conversation.latest_message.sent_at }}</p>
                </div>
            </div>
        </div>

        <div class="col-10 border py-3 px-3 overflow-auto"  id="chat-box" style="height: 550px">
            <body-message
                v-if="tempMessage"
                :messages="tempMessage"></body-message>
        </div>
    </div>
</template>

<script>
import bodyMessage from './Body'
export default {
    components: {
        bodyMessage
    },
    props: ['conversations'],
    data() {
        return {
            tempMessage: null
        }
    },
    methods: {
        setTemp (data) {

            this.tempMessage = data.messages
        }
    }
}
</script>