<template>
    <div>
            <wyswyg 
                class="text-justify"
                v-model="message" 
                data-vv-as="Message" 
                name="message" 
                v-validate="'required'"
                :value="message">
                </wyswyg>
            <p v-if="errors.first('message')"><span class="help-block text-danger" >{{errors.first('message')}}</span></p>

        <button
            v-if="!loading"
            class="btn btn-sm btn-primary rounded-0 my-2 btn-block"
            @click="validateBeforeSubmit"
        >
            Send
        </button>

        <div class="progress my-2" v-else>
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</template>

<script>
import wyswyg from '../Misc/Wyswyg'
import SwalAlerts from '../Misc/SwalAlerts'

export default {
    props: ['messages'],
    mixins: [SwalAlerts],
    components: {
        wyswyg
    },
    data() {
        return {
            message: null,
            loading: false
        }
    },
    methods: {
        validateBeforeSubmit () {
            this.$validator.validateAll().then((result) => {
                if(!result){

                    this.errorAlert('Some required fields are missing.')

                    return
                }

                this.submitDetails()
            }).catch((e) => {
                console.log(e)
            });
        },
        submitDetails () {
            this.loading = true

            axios.post(`${this.$store.state.Messages.TempMessage.path}/reply`, {
                message: this.message,
            }).then( response => {
                this.$store.commit('SET_MESSAGES', response.data.conversations)
                this.$store.commit('SET_TEMP_MESSAGE', response.data.conversation)
                this.message = null
                this.$validator.reset()
                Object.keys(document.getElementsByTagName('trix-editor')).forEach(function(key) {
                    document.getElementsByTagName('trix-editor')[key]['value'] = null
                })
                this.loading = false
            }).catch( error => {
                this.errorAlert()
                this.loading = false
            })

        }
    }
}
</script>

<style lang="scss">
    @import "~trix/dist/trix.css";

    trix-editor {
        height: 150px;
        overflow: auto;
    }

    .trix-button--icon-increase-nesting-level,
    .trix-button--icon-heading-1,
    .trix-button--icon-quote,
    .trix-button--icon-code,
    .trix-button-group--file-tools,
    .trix-button--icon-decrease-nesting-level { display: none!important; }
</style>